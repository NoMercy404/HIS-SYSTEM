<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Pacjenci</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<!-- Main Content -->
<main class="flex-1 p-10">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-3xl font-bold text-blue-600 mb-6">🧑‍⚕️ Pacjenci</h1>

    <form method="GET" action="{{ route('patients.index') }}" class="mb-6 flex flex-wrap gap-4 items-center">
        <input type="text" name="search" placeholder="Imię, Nazwisko lub PESEL"
               value="{{ request('search') }}"
               class="px-4 py-2 border rounded w-96 bg-sky-50 placeholder-black-50">

        <button type="submit"
                class="bg-yellow-200 text-black px-4 py-2 rounded hover:bg-yellow-300 transition">
            Szukaj
        </button>

        @php
            $isOnWard = request('on_ward') == 1;
            $params = request()->except('on_ward');
            if (!$isOnWard) {
                $params['on_ward'] = 1;
            }
        @endphp

        <a href="{{ route('patients.index', $params) }}"
           class="{{ $isOnWard ? 'bg-blue-200  hover:bg-blue-300' : 'bg-green-200 hover:bg-green-300' }} text-black px-4 py-2 rounded transition">
            {{ $isOnWard ? 'Pokaż wszystkich pacjentów' : 'Pokaż pacjentów na oddziale' }}
        </a>
        <a href="{{ route('patients.create') }}"
           class="bg-violet-200 text-black px-4 py-2 rounded hover:bg-violet-300 transition">
            Dodaj pacjenta
        </a>
    </form>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($patients->isEmpty())
            <p class="text-gray-500">Brak pasujących pacjentów.</p>
        @else
            <table class="w-full border-collapse text-left">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-2 px-4 border-b w-32">Imię</th>
                    <th class="py-2 px-4 border-b w-32">Nazwisko</th>
{{--                    <th class="py-2 px-4 border-b w-40">PESEL</th>--}}
                    <th class="py-2 px-4 border-b w-40">Data urodzenia</th>
                    <th class="py-2 px-4 border-b w-32">Telefon</th>
                    <th class="py-2 px-4 border-b w-64">Adres</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="openModal({{ $patient->id }})">
                        <td class="py-2 px-4 border-b">{{ $patient->first_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->last_name }}</td>
{{--                        <td class="py-2 px-4 border-b">{{ $patient->PESEL }}</td>--}}
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($patient->DateOfBirth)->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->phoneNumber }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->adress }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal -->
    <div id="patientModal" class="fixed inset-0 bg-green bg-opacity-30 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-xl shadow-2xl">
            <h2 class="text-3xl font-bold text-blue-600 mb-6 text-center">🧑‍⚕️ Szczegóły pacjenta</h2>

            <div id="modalContent" class="space-y-4">
                <!-- Wypełniane przez JavaScript -->
            </div>

            <div class="grid grid-cols-3 gap-4 pt-4 w-full">
                <a id="historyLink"
                   class="bg-green-200 text-black w-full py-2 rounded hover:bg-green-300 transition text-center cursor-pointer font-semibold">
                    Historia pacjenta
                </a>

                <form method="GET" id="editForm">
                    <button type="submit" class="bg-blue-200 text-black w-full py-2 rounded hover:bg-blue-300 transition font-semibold">
                        Edytuj pacjenta
                    </button>
                </form>

                <form method="POST" id="deleteForm" onsubmit="return confirm('Na pewno chcesz usunąć pacjenta?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-200 text-black w-full py-2 rounded hover:bg-red-300 transition font-semibold">
                        Usuń pacjenta
                    </button>
                </form>
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
    const patients = @json($patients);

    function openModal(id) {
        const modal = document.getElementById('patientModal');
        const content = document.getElementById('modalContent');
        const patient = patients.find(p => p.id === id);

        const birthDate = new Date(patient.DateOfBirth).toLocaleDateString('pl-PL');

        content.innerHTML = `
        <p><span class="font-semibold text-gray-700">Imię i nazwisko:</span> ${patient.first_name} ${patient.last_name}</p>
        <p><span class="font-semibold text-gray-700">PESEL:</span> ${patient.PESEL}</p>
        <p><span class="font-semibold text-gray-700">Data urodzenia:</span> ${birthDate}</p>
        <p><span class="font-semibold text-gray-700">Telefon:</span> ${patient.phoneNumber}</p>
        <p><span class="font-semibold text-gray-700">Adres:</span> ${patient.adress}</p>
    `;

        document.getElementById('editForm').action = `/patients/${id}/edit`;
        document.getElementById('deleteForm').action = `/patients/${id}`;
        document.getElementById('historyLink').href = `/patients/${id}/history`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeModal() {
        const modal = document.getElementById('patientModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>

</body>
</html>
