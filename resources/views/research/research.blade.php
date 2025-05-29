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
        <a href="{{ route('research.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            ➕ Dodaj badanie
        </a>
    </div>

    <div class="flex items-center gap-4 mb-6">
        <form method="GET" action="{{ route('research.index') }}" class="flex items-center gap-2">
            <label for="status" class="text-sm text-gray-700">Filtruj status:</label>
            <select name="status" id="status" onchange="this.form.submit()" class="px-3 py-2 border rounded">
                <option value="">Wszystkie</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Zakończone</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>W toku</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Anulowane</option>
            </select>
        </form>
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
                    <th class="py-2 px-4 border-b">Data</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Wynik</th>
                    <th class="py-2 px-4 border-b text-center">Akcje</th>
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
                        <td class="py-2 px-4 border-b">{{ $research->result }}</td>
                        <td class="py-2 px-4 border-b text-center space-x-2">
                            <a href="{{ route('research.show', $research->id) }}" class="text-blue-600 hover:underline">Szczegóły</a>
                            <a href="{{ route('research.edit', $research->id) }}" class="text-yellow-600 hover:underline">Edytuj</a>
                            <form action="{{ route('research.destroy', $research->id) }}" method="POST" class="inline" onsubmit="return confirm('Na pewno chcesz usunąć?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
</body>
</html>
