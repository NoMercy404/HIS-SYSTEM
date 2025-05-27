@php use Illuminate\Support\Str; @endphp

    <!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zmień hasło</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md p-6 space-y-4">
    <h2 class="text-xl font-bold text-blue-600 mb-6">Menu</h2>
    <nav class="flex flex-col space-y-2">
        <a href="{{ route('visits.index') }}" class="text-gray-700 hover:text-blue-600">📅️ Wizyty</a>
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
<main class="flex-1 p-10">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Zmień hasło</h2>
        @if(session('status'))
            @php
                $statusMessage = session('status');
                $statusColor = Str::contains($statusMessage, 'przestarzałe') ? 'text-orange-600' : 'text-green-600';
            @endphp
            <p class="{{ $statusColor }} font-semibold mb-4">{{ $statusMessage }}</p>
        @endif


    @if ($errors->any())
            <div class="text-red-600 mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.change') }}" class="space-y-4">
            @csrf

            <div>
                <label for="current_password" class="block mb-1 font-semibold">Obecne hasło</label>
                <input type="password" name="current_password" id="current_password" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label for="new_password" class="block mb-1 font-semibold">Nowe hasło</label>
                <input type="password" name="new_password" id="new_password" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label for="new_password_confirmation" class="block mb-1 font-semibold">Powtórz nowe hasło</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                Zmień hasło
            </button>
        </form>
    </div>
</main>

</body>
</html>
