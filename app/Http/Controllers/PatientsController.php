<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::query();

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

        // Sortowanie od najstarszego do najmłodszego
        $patients = $query->orderBy('DateOfBirth')->get();

        return view('patients.index', [
            'patients' => $patients,
            'search' => $search
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Patients $patients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patients $patients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patients $patients)
    {
        //
    }
}
