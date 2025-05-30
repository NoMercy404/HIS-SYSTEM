<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj badanie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">Dodaj badanie</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('research.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="hospital_id" class="block font-semibold mb-1">Wybierz Pacjenta (musi być na oddziale)</label>
            <select name="hospital_id" id="hospital_id" required class="w-full border px-4 py-2 rounded bg-sky-50">
                <option value="">Wybierz pacjenta</option>
                @foreach ($hospitalisations as $hosp)
                    <option value="{{ $hosp->id }}" {{ old('hospital_id') == $hosp->id ? 'selected' : '' }}>
                        {{ $hosp->patient->first_name }} {{ $hosp->patient->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="research_type" class="block font-semibold mb-1">Typ badania</label>
            <select name="research_type" id="research_type" required class="w-full border px-4 py-2 rounded bg-sky-50">
                <option value="">Wybierz typ</option>
                <option value="radiologiczne" {{ old('research_type') == 'radiologiczne' ? 'selected' : '' }}>Radiologiczne</option>
                <option value="laboratoryjne" {{ old('research_type') == 'laboratoryjne' ? 'selected' : '' }}>Laboratoryjne</option>
                <option value="zabieg" {{ old('research_type') == 'zabieg' ? 'selected' : '' }}>Zabieg</option>
            </select>
        </div>

        <div>
            <label for="note" class="block font-semibold mb-1">Opis badania</label>
            <textarea name="note" id="note" rows="4" required class="w-full border px-4 py-2 rounded" placeholder="Wprowadź szczegóły badania...">{{ old('note') }}</textarea>
        </div>

        <div class="flex items-center gap-4 justify-center pt-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Zapisz badanie
            </button>

            <a href="{{ route('research.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                ← Wróć do listy badań
            </a>
        </div>
    </form>
</div>

</body>
</html>
