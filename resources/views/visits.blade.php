<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizyty</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md p-6 space-y-4">
    <h2 class="text-xl font-bold text-blue-600 mb-6">Menu</h2>
    <nav class="flex flex-col space-y-2">
        <a href="{{ route('visits.index') }}" class="text-gray-700 hover:text-blue-600">📅 Wizyty</a>
        <a href="{{ route('patients.index') }}" class="text-gray-700 hover:text-blue-600">🧑‍⚕️ Pacjenci</a>
        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">ℹ️ O mnie</a>
        <a href="{{ route('password.change.form') }}" class="text-gray-700 hover:text-blue-600">🔐 Zmień hasło</a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-6">
        @csrf
        <button type="submit"
                class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
            Wyloguj się
        </button>
    </form>
</aside>

<!-- Main content -->
<main class="flex-1 p-10">
    @php
        $headerTitle = match(request('filter')) {
            'mine' => '👨‍⚕️ Moje wizyty',
            'today' => '📅 Dzisiejsze wizyty',
            default => '📋 Wszystkie wizyty',
        };
    @endphp

    <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ $headerTitle }}</h1>
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('visits.index') }}"
           class="px-4 py-2 {{ request('filter') === null && request('doctor_id') === null ? 'bg-yellow-200' : 'bg-yellow-200' }} rounded hover:bg-yellow-300">
            Wszystkie wizyty
        </a>

        <a href="{{ route('visits.index', ['filter' => 'mine']) }}"
           class="px-4 py-2 {{ request('filter') === 'mine' ? 'bg-blue-300' : 'bg-blue-200' }} rounded hover:bg-blue-300">
            Moje wizyty
        </a>

        <a href="{{ route('visits.index', ['filter' => 'today']) }}"
           class="px-4 py-2 {{ request('filter') === 'today' ? 'bg-green-300' : 'bg-green-200' }} rounded hover:bg-green-300">
            Dzisiejsze wizyty
        </a>

        @if(request('filter') !== 'mine')
            <form method="GET" action="{{ route('visits.index') }}">
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                <select name="doctor_id" onchange="this.form.submit()" class="ml-4 px-3 py-2 border rounded">
                    <option value="">-- Wybierz lekarza --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->first_name[0] }}. {{ $doctor->last_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif

        <a href="{{ route('visits.create') }}"
           class="ml-auto bg-violet-200 text-black px-4 py-2 rounded hover:bg-violet-300 transition">
            Dodaj wizytę
        </a>
    </div>




    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($visits->isEmpty())
            <p class="text-gray-500">Brak zaplanowanych wizyt.</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-700">

                    <th class="py-2 px-4 border-b">Pacjent</th>
                    <th class="py-2 px-4 border-b">Lekarz</th>
                    <th class="py-2 px-4 border-b">Data</th>
                    <th class="py-2 px-4 border-b">Godzina</th>
                    <th class="py-2 px-4 border-b">Gabinet</th>
                    <th class="py-2 px-4 border-b">Notatka</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visits as $visit)
                    @php

                    $visitDate = $visit->visit_date instanceof \Carbon\Carbon
                        ? $visit->visit_date
                        : \Carbon\Carbon::parse($visit->visit_date);

                    $isPast = $visitDate->lt(now());



                    @endphp
                    <tr class="{{ $isPast ? 'bg-gray-200 text-gray-500' : 'hover:bg-gray-50 cursor-pointer' }}"
                        onclick="openModal({{ $visit->id }})">
                        <td class="py-2 px-4 border-b">
                            {{ $visit->patient->first_name }} {{ $visit->patient->last_name }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ strtoupper(substr($visit->doctor->first_name, 0, 1)) }}.{{ $visit->doctor->last_name }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('d.m.Y') }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('H:i') }}
                        </td>
                        <td class="py-2 px-4 border-b">{{ $visit->visit_room }}</td>
                        <td class="py-2 px-4 border-b">{{ $visit->visit_note }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <!-- Modal -->
    <div id="visitModal" class="fixed inset-0 bg-green bg-opacity-30 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-xl shadow-2xl">
            <h2 class="text-3xl font-bold text-blue-600 mb-6 text-center">📋 Szczegóły wizyty</h2>

            <div id="modalContent" class="space-y-6">
                <!-- Wypełniane przez JavaScript -->
            </div>

            <div class="flex justify-center mt-6 w-full">
                <button onclick="closeModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
                    ← Wróć do listy pacjentów
                </button>
            </div>
        </div>
    </div>



</main>
<script>
    const visits = @json($visits);

    function openModal(id) {
        const modal = document.getElementById('visitModal');
        const content = document.getElementById('modalContent');
        const visit = visits.find(v => v.id === id);

        const formattedDate = new Date(visit.visit_date).toISOString().slice(0, 16);
        const displayDate = new Date(visit.visit_date).toLocaleString('pl-PL');

        content.innerHTML = `
        <div>
            <p><span class="font-semibold text-gray-700">👤 Pacjent:</span> ${visit.patient.first_name} ${visit.patient.last_name}</p>
            <p><span class="font-semibold text-gray-700">🧑‍⚕️ Lekarz:</span> ${visit.doctor.first_name} ${visit.doctor.last_name}</p>
            <p><span class="font-semibold text-gray-700">🏢 Gabinet:</span> ${visit.visit_room}</p>
            <p><span class="font-semibold text-gray-700">📅 Data i godzina:</span> ${displayDate}</p>
        </div>
        <div class="grid grid-cols-2 gap-4 pt-4 w-full">
        <form action="/visits/${visit.id}" method="POST" onsubmit="return confirm('Na pewno chcesz anulować?')">
            @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-200 text-black w-full py-2 rounded hover:bg-red-300 transition">Anuluj wizytę</button>
    </form>
        <form action="/visits/${visit.id}/edit" method="GET">
            <button type="submit" class="bg-blue-200 text-black w-full py-2 rounded hover:bg-blue-300 transition">
                Edytuj wizytę
            </button>
        </form>
        </div>
    `;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeModal() {
        const modal = document.getElementById('visitModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>

</body>
</html>
