<?php

namespace App\Http\Controllers;

use App\Models\Hospitalisation;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patients::query();

        // Filtrowanie po imieniu, nazwisku lub PESEL
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('PESEL', 'like', "%$search%");
            });
        }

        // Filtrowanie po tym, czy pacjent jest na oddziale
        if ($request->has('on_ward')) {
            $query->where('is_on_ward', true);
        }

        // Sortowanie po nazwisku
        $patients = $query->orderBy('last_name')->get();

        return view('patients', [
            'patients' => $patients,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'PESEL' => 'required|string|max:11|unique:patients',
            'DateOfBirth' => 'required|date',
            'phoneNumber' => 'nullable|string|max:20',
            'adress' => 'nullable|string|max:255',
        ]);
        $validated['is_on_ward'] = $request->has('is_on_ward') ? 1 : 0;

        // Tworzymy pacjenta
        $patient = \App\Models\Patients::create($validated);

        // Jeśli pacjent jest na oddziale, tworzymy hospitalizację
        if ($validated['is_on_ward']) {
            Hospitalisation::create([
                'patient_id' => $patient->id,
                'date_of_hospital_admission' => now(), // data przyjęcia to teraz
                'discharge_date' => null,
                'disease_number' => 'Brak danych', // lub możesz pozwolić na pustą wartość
            ]);
        }

        return redirect()->route('patients.index')->with('success', 'Pacjent dodany!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patient = Patients::findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patients $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patients $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'PESEL' => 'required|string|size:11',
            'DateOfBirth' => 'required|date',
            'phoneNumber' => 'nullable|string|max:15',
            'adress' => 'nullable|string|max:255',
            'is_on_ward' => 'nullable|boolean',
        ]);

        $isOnWard = $request->has('is_on_ward');
        $validated['is_on_ward'] = $isOnWard;

        $patient->update($validated);

        $existingHospitalisation = Hospitalisation::where('patient_id', $patient->id)
            ->whereNull('discharge_date')
            ->latest('date_of_hospital_admission')
            ->first();

        if ($isOnWard && !$existingHospitalisation) {
            Hospitalisation::create([
                'patient_id' => $patient->id,
                'date_of_hospital_admission' => now(),
                'discharge_date' => null,
                'disease_number' => 'Brak danych',
            ]);
        } elseif (!$isOnWard && $existingHospitalisation) {
            $existingHospitalisation->delete();
        }

        return redirect()->route('patients.index')->with('success', 'Pacjent został zaktualizowany.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patients $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Pacjent został usunięty.');
    }

    /**
     * Show history of visits and researches for a patient.
     */
    public function history($id)
    {
        $patient = Patients::with(['visits', 'hospitalisations.researches'])->findOrFail($id);

        // Zbierz wszystkie badania ze wszystkich hospitalizacji pacjenta
        $researches = $patient->hospitalisations->flatMap(function ($hospitalisation) {
            return $hospitalisation->researches;
        })->sortByDesc('date_of_research');

        // Posortuj wizyty malejąco po dacie wizyty
        $visits = $patient->visits->sortByDesc('visit_date');

        return view('patients.history', [
            'patient' => $patient,
            'visits' => $visits,
            'researches' => $researches,
        ]);
    }
}
