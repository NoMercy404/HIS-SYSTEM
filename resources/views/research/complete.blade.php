<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Zakończ badanie</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">Zakończ badanie</h1>

    <form action="{{ route('research.complete', $research->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="result" class="block text-sm font-medium text-gray-700">Wynik badania</label>
            <textarea name="result" id="result" rows="5"
                      class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                      required>{{ old('result', $research->result) }}</textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('research.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Anuluj
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Zakończ badanie
            </button>
        </div>
    </form>
</div>

</body>
</html>
