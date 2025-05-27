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
        <a href="{{ route('visits.my') }}" class="text-gray-700 hover:text-blue-600">👨‍⚕️ Moje wizyty</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">🧑‍⚕️ Pacjenci</a>
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
    <h1 class="text-3xl font-bold text-blue-600 mb-6">📅 Wizyty</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($visits->isEmpty())
            <p class="text-gray-500">Brak zaplanowanych wizyt.</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-2 px-4 border-b">ID Pacjenta</th>
                    <th class="py-2 px-4 border-b">ID Lekarza</th>
                    <th class="py-2 px-4 border-b">Data wizyty</th>
                    <th class="py-2 px-4 border-b">Gabinet</th>
                    <th class="py-2 px-4 border-b">Notatka</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visits as $visit)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $visit->patient_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $visit->doctor_id }}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d.m.Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ $visit->visit_room }}</td>
                        <td class="py-2 px-4 border-b">{{ $visit->visit_note }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

</body>
</html>
