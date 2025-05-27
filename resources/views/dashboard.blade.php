<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md p-6 space-y-4">
    <h2 class="text-xl font-bold text-blue-600 mb-6">Menu</h2>
    <nav class="flex flex-col space-y-2">
        <a href="{{ route('visits.index') }}" class="text-gray-700 hover:text-blue-600">📅 Wizyty</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">🧑‍⚕️ Pacjenci</a>
        <a href="#" class="text-gray-700 hover:text-blue-600">ℹ️ O mnie</a>
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
    @if(session('status'))
        <p class="text-green-600 font-semibold mb-4">{{ session('status') }}</p>
    @endif

    <div class="bg-white shadow-lg rounded-xl p-8 text-center">
        <h1 class="text-3xl font-bold text-blue-600 mb-4">
            Witaj, {{ $user->first_name }} {{ $user->last_name }}!
        </h1>

        @if (!is_null($daysLeft))
            @if ($daysLeft > 0)
                <p class="text-orange-600 font-semibold mb-4">
                    Musisz zmienić hasło za {{ $daysLeft }} dni.
                </p>
            @else
                <p class="text-red-600 font-semibold mb-4">
                    Twoje hasło jest przeterminowane – musisz je natychmiast zmienić!
                </p>
            @endif
        @else
            <p class="text-gray-500 italic mb-4">Brak informacji o ostatniej zmianie hasła.</p>
        @endif
    </div>
</main>

</body>
</html>
