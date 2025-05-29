<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj pacjenta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center">➕ Dodaj pacjenta</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Imię</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block font-semibold mb-1">Nazwisko</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block font-semibold mb-1">PESEL</label>
            <input type="text" name="PESEL" value="{{ old('PESEL') }}" required maxlength="11" class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block font-semibold mb-1">Data urodzenia</label>
            <input type="date" name="DateOfBirth" value="{{ old('DateOfBirth') }}" required class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block font-semibold mb-1">Telefon</label>
            <input type="text" name="phoneNumber" value="{{ old('phoneNumber') }}" class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block font-semibold mb-1">Adres</label>
            <input type="text" name="adress" value="{{ old('adress') }}" class="w-full border px-4 py-2 rounded" />
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" id="is_on_ward" name="is_on_ward" value="1" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_on_ward" class="font-semibold">Czy pacjent jest na wydziale?</label>
        </div>

        <div class="flex items-center gap-4 justify-center pt-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Zapisz pacjenta
            </button>

            <a href="{{ route('patients.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                ← Wróć do listy pacjentów
            </a>
        </div>
    </form>
</div>

</body>
</html>
