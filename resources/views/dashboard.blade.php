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
<main class="flex-1 p-10 relative">


    @if(session('status'))
        <p class="text-green-600 font-semibold mb-4">{{ session('status') }}</p>
    @endif

    <!-- Dane użytkownika -->
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">📄 Informacje o użytkowniku {{ $user->first_name }}</h1>

        <ul class="space-y-3 text-gray-700">
            <li><strong>Imię:</strong> {{ $user->first_name }}</li>
            <li><strong>Nazwisko:</strong> {{ $user->last_name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li>
                <strong>Zarejestrowany od:</strong>
                {{ round(\Carbon\Carbon::parse($user->created_at)->diffInRealDays(now())) }} dni
                ({{ $user->created_at->format('d.m.Y') }})
            </li>
        </ul>

        @if (!is_null($daysLeft))
            <div class="mt-6">
                @if ($daysLeft > 0)
                    <p class="text-orange-600 font-semibold">
                        Musisz zmienić hasło za {{ $daysLeft }} dni.
                    </p>
                @else
                    <p class="text-red-600 font-semibold">
                        Twoje hasło jest przeterminowane – musisz je natychmiast zmienić!
                    </p>
                @endif
            </div>
        @else
            <p class="text-gray-500 italic mt-6">Brak informacji o ostatniej zmianie hasła.</p>
        @endif
    </div>
</main>

</body>
</html>
