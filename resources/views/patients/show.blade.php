<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły pacjenta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen p-10">

<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">👤 Szczegóły pacjenta</h1>

    <ul class="space-y-2">
        <li><strong>Imię:</strong> {{ $patient->first_name }}</li>
        <li><strong>Nazwisko:</strong> {{ $patient->last_name }}</li>
        <li><strong>PESEL:</strong> {{ $patient->PESEL }}</li>
        <li><strong>Data urodzenia:</strong> {{ \Carbon\Carbon::parse($patient->DateOfBirth)->format('d.m.Y') }}</li>
        <li><strong>Telefon:</strong> {{ $patient->phoneNumber }}</li>
        <li><strong>Adres:</strong> {{ $patient->adress }}</li>
        <li><strong>Na oddziale:</strong> {{ $patient->is_on_ward ? 'Tak' : 'Nie' }}</li>
    </ul>

    <a href="{{ route('patients.index') }}"
       class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        ⬅️ Wróć do listy
    </a>
</div>

</body>
</html>
