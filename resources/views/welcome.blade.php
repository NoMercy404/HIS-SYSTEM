<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Witamy w systemie szpitalnym</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50 text-gray-800">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="text-center bg-white p-10 rounded-2xl shadow-xl max-w-lg w-full">
        <h1 class="text-4xl font-extrabold text-blue-600 mb-4">Witamy! 🏥</h1>
        <p class="text-lg mb-6">To jest strona powitalna systemu szpitalnego. Zaloguj się, aby kontynuować.</p>
        <a href="/login"
           class="inline-block bg-yellow-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
            Przejdź do logowania
        </a>
    </div>
</div>

</body>
</html>
