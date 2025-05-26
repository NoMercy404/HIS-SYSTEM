<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">Zaloguj się</h1>

    @if (session('error'))
        <div class="text-red-600 mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold mb-1">Hasło</label>
            <input type="password" name="password" required class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
            Zaloguj
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        Nie masz konta?
        <a href="{{ route('register') }}" class="text-blue-600 underline">Zarejestruj się</a>
    </p>
</div>

</body>
</html>
