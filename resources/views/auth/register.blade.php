<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Zarejestruj się</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="first_name" class="block mb-1 font-semibold">Imię</label>
            <input type="text" name="first_name" id="first_name" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="last_name" class="block mb-1 font-semibold">Nazwisko</label>
            <input type="text" name="last_name" id="last_name" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" id="email" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password" class="block mb-1 font-semibold">Hasło</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label for="password_confirmation" class="block mb-1 font-semibold">Powtórz hasło</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_doctor" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2 text-gray-700">Oświadczam iż jestem lekarzem</span>
            </label>
        </div>
        @if ($errors->any())
            <div class="text-red-600 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
            Zarejestruj się
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        Masz już konto?
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Zaloguj się</a>
    </p>
</div>

</body>
</html>
