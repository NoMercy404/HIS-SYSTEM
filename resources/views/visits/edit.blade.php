<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj wizytę</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">Edytuj wizytę</h1>

    <form action="{{ route('visits.update', $visit->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Pacjent:</label>
            <select name="patient_id" class="w-full border px-3 py-2 rounded">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $visit->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Lekarz:</label>
            <select name="doctor_id" class="w-full border px-3 py-2 rounded">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $visit->doctor_id == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Gabinet:</label>
            <input type="text" name="visit_room" value="{{ $visit->visit_room }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium mb-1">Data i godzina wizyty:</label>
            <input type="datetime-local" name="visit_date"
                   value="{{ \Carbon\Carbon::parse($visit->visit_date)->format('Y-m-d\TH:i') }}"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium mb-1">Notatka:</label>
            <textarea name="visit_note" rows="3" class="w-full border px-3 py-2 rounded">{{ $visit->visit_note }}</textarea>
        </div>

        <div class="flex items-center gap-4 justify-center pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Zapisz zmiany
            </button>
            <a href="{{ route('visits.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                ← Wróć do listy wizyt
            </a>
        </div>
    </form>
</div>

</body>
</html>
