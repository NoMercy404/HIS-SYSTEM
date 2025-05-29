<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj wizytę</title>
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
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
            Wyloguj się
        </button>
    </form>
</aside>

<!-- Main Content -->
<main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">✏️ Edytuj wizytę</h1>

    <form action="{{ route('visits.update', $visit->id) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4 max-w-xl">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pacjent:</label>
            <select name="patient_id" class="w-full border rounded px-3 py-2">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $visit->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </option>

                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lekarz:</label>
            <select name="doctor_id" class="w-full border rounded px-3 py-2">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $visit->doctor_id == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gabinet:</label>
            <input type="text" name="visit_room" class="w-full border rounded px-3 py-2" value="{{ $visit->visit_room }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Data i godzina wizyty:</label>
            <input type="datetime-local" name="visit_date"
                   value="{{ \Carbon\Carbon::parse($visit->visit_date)->format('Y-m-d\TH:i') }}"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notatka:</label>
            <textarea name="visit_note" rows="4" class="w-full border rounded px-3 py-2">{{ $visit->visit_note }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('visits.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">↩️ Anuluj</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">💾 Zapisz zmiany</button>
        </div>
    </form>
</main>

</body>
</html>
