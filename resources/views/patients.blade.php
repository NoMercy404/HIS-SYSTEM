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
        <a href="{{ route('visits.index') }}" class="text-gray-700 hover:text-blue-600">📅️ Wizyty</a>
        <a href="{{ route('patients.index') }}" class="text-gray-700 hover:text-blue-600">🧑‍⚕️ Pacjenci</a>
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
    <h1 class="text-3xl font-bold text-blue-600 mb-6">🧑‍⚕️ Pacjenci</h1>

    <!-- Pole wyszukiwania i filtr "Na oddziale" -->
    <form method="GET" action="{{ route('patients.index') }}" class="mb-6 flex flex-wrap gap-4 items-center">
        <input type="text" name="search" placeholder="Szukaj po imieniu, nazwisku lub PESELu"
               value="{{ request('search') }}"
               class="px-4 py-2 border rounded w-64">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
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
                    <th class="py-2 px-4 border-b w-40">PESEL</th>
                    <th class="py-2 px-4 border-b w-40">Data urodzenia</th>
                    <th class="py-2 px-4 border-b w-32">Telefon</th>
                    <th class="py-2 px-4 border-b w-64">Adres</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50 cursor-pointer"
                        onclick="window.location='{{ route('patients.show', $patient->id) }}'">
                        <td class="py-2 px-4 border-b">{{ $patient->first_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->last_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->PESEL }}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($patient->DateOfBirth)->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->phoneNumber }}</td>
                        <td class="py-2 px-4 border-b">{{ $patient->adress }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        @endif
    </div>
</main>

</body>
</html>
