<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
@if(session('status'))
    <p class="text-green-600 font-semibold mb-4">{{ session('status') }}</p>
@endif

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-xl text-center">
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




    <a href="{{ route('password.change.form') }}"
       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Zmień hasło
    </a>



    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
        Wyloguj się
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

</body>
</html>

