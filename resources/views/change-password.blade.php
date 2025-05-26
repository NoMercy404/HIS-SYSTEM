<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zmiana hasła</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Zmiana hasła</h2>

    <form method="POST" action="{{ route('password.change') }}" class="space-y-4">
        @csrf

        <div>
            <label for="password" class="block font-semibold">Nowe hasło</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password_confirmation" class="block font-semibold">Powtórz hasło</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
            Zmień hasło
        </button>
    </form>
</div>

</body>
</html>
