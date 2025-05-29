<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj wizytę</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen p-10">

<h1 class="text-3xl font-bold text-blue-600 mb-6">Dodaj wizytę</h1>

<form method="POST" action="{{ route('visits.store') }}" class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
    @csrf

    <div class="mb-4">
        <label for="patient_id" class="block mb-1 font-medium">Pacjent:</label>
        <select name="patient_id" id="patient_id" required class="w-full border px-3 py-2 rounded">
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="doctor_id" class="block mb-1 font-medium">Lekarz:</label>
        <select name="doctor_id" id="doctor_id" required class="w-full border px-3 py-2 rounded">
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->first_name }} {{ $doctor->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="visit_date" class="block mb-1 font-medium">Data i godzina:</label>
        <input type="datetime-local" name="visit_date" id="visit_date" required class="w-full border px-3 py-2 rounded">
    </div>

    <div class="mb-4">
        <label for="visit_room" class="block mb-1 font-medium">Gabinet:</label>
        <input type="text" name="visit_room" id="visit_room" required class="w-full border px-3 py-2 rounded">
    </div>

    <div class="mb-4">
        <label for="visit_note" class="block mb-1 font-medium">Notatka:</label>
        <textarea name="visit_note" id="visit_note" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Zapisz wizytę
    </button>
    <a href="{{ route('visits.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
        Anuluj
    </a>
</form>

</body>
</html>
