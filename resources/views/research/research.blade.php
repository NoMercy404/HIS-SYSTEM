<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badania</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md p-6 space-y-4">
    <h2 class="text-xl font-bold text-blue-600 mb-6">Menu</h2>
    <nav class="flex flex-col space-y-2">
        <a href="{{ route('visits.index') }}" class="text-gray-700 hover:text-blue-600">📅 Wizyty</a>
        <a href="{{ route('patients.index') }}" class="text-gray-700 hover:text-blue-600">🧑‍⚕️ Pacjenci</a>
        <a href="{{ route('research.index') }}" class="text-gray-700 hover:text-blue-600">🧪 Badania</a>
        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">ℹ️ O mnie</a>
        <a href="{{ route('password.change.form') }}" class="text-gray-700 hover:text-blue-600">🔐 Zmień hasło</a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-6">
        @csrf
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
            Wyloguj się
        </button>
    </form>
</aside>

<!-- Main content -->
<main class="flex-1 p-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-blue-600">📋 Lista badań</h1>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('research.index') }}" class="flex flex-wrap items-center gap-2">
            <select name="status" id="status" onchange="this.form.submit()" class="px-3 py-2 border rounded bg-sky-50">
                <option value="">Wszystkie statusy</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Zakończone</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>W toku</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Anulowane</option>
            </select>

            <select name="type" id="type" onchange="this.form.submit()" class="px-3 py-2 border rounded bg-sky-50">
                <option value="">Wszystkie typy</option>
                <option value="radiologiczne" {{ request('type') == 'radiologiczne' ? 'selected' : '' }}>Radiologiczne</option>
                <option value="laboratoryjne" {{ request('type') == 'laboratoryjne' ? 'selected' : '' }}>Laboratoryjne</option>
                <option value="zabieg" {{ request('type') == 'zabieg' ? 'selected' : '' }}>Zabieg</option>
            </select>
        </form>

        <a href="{{ route('research.create') }}"
           class="bg-violet-200 text-black px-4 py-2 rounded hover:bg-violet-300 transition whitespace-nowrap">
            Dodaj badanie
        </a>
    </div>


    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($researches->isEmpty())
            <p class="text-gray-500">Brak badań do wyświetlenia.</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-2 px-4 border-b">Pacjent</th>
                    <th class="py-2 px-4 border-b">Typ badania</th>
                    <th class="py-2 px-4 border-b">Opis</th>
                    <th class="py-2 px-4 border-b">Data Wystawienia</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($researches as $research)
                    @php
                        $statusMap = [
                            'Zakończone' => 'Zakończone',
                            'W toku' => 'W toku',
                            'Anulowane' => 'Anulowane',
                        ];
                        $statusColors = [
                            'Zakończone' => 'bg-green-200 text-green-800',
                            'W toku' => 'bg-yellow-200 text-yellow-800',
                            'Anulowane' => 'bg-red-200 text-red-800',
                        ];
                        $translatedStatus = $statusMap[$research->status] ?? 'Nieznany';
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">
                            {{ $research->hospitalisation->patient->first_name ?? 'Brak' }}
                            {{ $research->hospitalisation->patient->last_name ?? '' }}
                        </td>
                        <td class="py-2 px-4 border-b capitalize">{{ $research->research_type }}</td>
                        <td class="py-2 px-4 border-b">{{ $research->note }}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($research->date_of_research)->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border-b">
                            <span class="inline-block min-w-[7rem] text-center px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$translatedStatus] ?? 'bg-gray-200 text-gray-800' }}">
                                {{ $translatedStatus }}
                            </span>
                        </td>
                        @php
                            $actions = [];

                            if ($research->status !== 'Zakończone') {
                                $actions[] = 'complete';
                            }

                            if ($research->status !== 'Anulowane') {
                                $actions[] = 'cancel';
                            }

                            $actions[] = 'edit';
                            $actions[] = 'delete';

                            $columns = count($actions) === 3 ? 'grid-cols-3' : 'grid-cols-2';
                        @endphp

                        <td class="py-2 px-4 border-b">
                            <div class="grid {{ $columns }} gap-5 justify-items-center">

                                @if(in_array('complete', $actions))
                                    <a href="{{ route('research.complete.form', $research->id) }}"
                                       class="p-1 bg-green-100 text-green-600 rounded hover:bg-green-200"
                                       title="Zakończ badanie">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </a>

                                @endif


                            @if(in_array('cancel', $actions))
                                    <form action="{{ route('research.cancel', $research->id) }}" method="POST"
                                          onsubmit="return confirm('Czy na pewno chcesz anulować to badanie?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"

                                                class="p-1 bg-red-100 text-red-600 rounded hover:bg-red-200"
                                                title="Anuluj badanie">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if(in_array('edit', $actions))
                                    <a href="{{ route('research.edit', $research->id) }}"
                                       class="p-1 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200"
                                       title="Edytuj">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                @endif

                                @if(in_array('delete', $actions))
                                    <form action="{{ route('research.destroy', $research->id) }}" method="POST"
                                          onsubmit="return confirm('Na pewno chcesz usunąć?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200"

                                                title="Usuń">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>




                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

<script>
    function toggleCompleteForm(id) {
        const form = document.getElementById(`complete-form-${id}`);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-edit-button]').forEach(button => {
            button.addEventListener('click', () => {
                const row = button.closest('tr');
                const isEditing = row.dataset.editing === 'true';

                if (!isEditing) {
                    row.dataset.editing = 'true';
                    button.innerHTML = '💾';
                    button.title = 'Zatwierdź';

                    row.querySelectorAll('[data-editable]').forEach(cell => {
                        const key = cell.dataset.field;
                        const value = cell.textContent.trim();
                        let input;

                        if (key === 'research_type') {
                            input = document.createElement('select');
                            ['radiologiczne', 'laboratoryjne', 'zabieg'].forEach(opt => {
                                const option = document.createElement('option');
                                option.value = opt;
                                option.text = opt.charAt(0).toUpperCase() + opt.slice(1);
                                if (opt === value) option.selected = true;
                                input.appendChild(option);
                            });
                        } else if (key === 'note') {
                            input = document.createElement('textarea');
                            input.rows = 2;
                            input.textContent = value;
                        } else if (key === 'date_of_research') {
                            input = document.createElement('input');
                            input.type = 'date';
                            input.value = new Date(value.split('.').reverse().join('-')).toISOString().split('T')[0];
                        } else if (key === 'status') {
                            input = document.createElement('select');
                            ['Zakończone', 'W toku', 'Anulowane'].forEach(opt => {
                                const option = document.createElement('option');
                                option.value = opt;
                                option.text = opt;
                                if (opt === value) option.selected = true;
                                input.appendChild(option);
                            });
                        } else {
                            input = document.createElement('input');
                            input.type = 'text';
                            input.value = value;
                        }

                        input.classList.add('w-full', 'px-2', 'py-1', 'border', 'rounded');
                        cell.dataset.original = value;
                        cell.innerHTML = '';
                        cell.appendChild(input);
                    });

                } else {
                    row.dataset.editing = 'false';
                    button.innerHTML = '✏️';
                    button.title = 'Edytuj';

                    const id = button.dataset.id;
                    const updatedData = {};

                    row.querySelectorAll('[data-editable]').forEach(cell => {
                        const key = cell.dataset.field;
                        const input = cell.querySelector('input, textarea, select');
                        const newValue = input.value;

                        updatedData[key] = newValue;
                        cell.textContent = newValue; // Aktualizuj widok
                    });

                    // TODO: wyślij dane na backend
                    console.log(`Zaktualizowano rekord ID ${id}:`, updatedData);

                    // Ewentualnie: fetch(`/research/${id}`, { method: 'PUT', body: JSON.stringify(updatedData), ... })
                }
            });
        });
    });

</script>

</body>
</html>
