<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Historia pacjenta - {{ $patient->first_name }} {{ $patient->last_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen p-10">

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-blue-600 mb-6">📄 Historia pacjenta: {{ $patient->first_name }} {{ $patient->last_name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Wizyty --}}
        <div>
            <h2 class="text-xl font-semibold text-blue-500 mb-3">🩺 Wizyty</h2>
            @if($visits->isEmpty())
                <p class="text-gray-600">Brak zarejestrowanych wizyt.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($visits as $visit)
                        <li class="py-2">
                            <strong>Data:</strong> {{ \Carbon\Carbon::parse($visit->visit_date)->format('d.m.Y H:i') }}<br>
                            <strong>Opis:</strong> {{ $visit->visit_note ?? 'Brak opisu' }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Badania --}}
        <div>
            <h2 class="text-xl font-semibold text-green-600 mb-3">🧪 Badania</h2>
            @if($researches->isEmpty())
                <p class="text-gray-600">Brak zarejestrowanych badań.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($researches as $research)
                        <li class="py-2">
                            <strong>{{ $research->research_type }} ({{ \Carbon\Carbon::parse($research->date_of_research)->format('d.m.Y') }})</strong><br>
                            Wynik: {{ $research->result ?? 'Brak wyniku' }}<br>
                            @if($research->note)
                                <em>Uwagi: {{ $research->note }}</em>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <a href="{{ route('patients.index') }}" class="mt-6 inline-block bg-blue-200 text-black px-4 py-2 rounded hover:bg-blue-300 transition">
        ← Wróć do listy pacjentów
    </a>
</div>

</body>
</html>
