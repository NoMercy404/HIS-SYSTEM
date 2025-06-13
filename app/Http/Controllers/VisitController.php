<?php

namespace App\Http\Controllers;


use App\Models\Visit;
use App\Models\User;
use App\Models\Patients;

use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = \App\Models\Patients::orderBy('last_name')->get();
        $doctors = \App\Models\User::where('role', 'lekarz')->orderBy('last_name')->get();

        return view('visits.create', compact('patients', 'doctors'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'visit_date' => 'required|date|after:now',
            'visit_room' => 'required|string|max:255',
            'visit_note' => 'nullable|string',
        ]);

        Visit::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'visit_date' => $request->visit_date,
            'visit_room' => $request->visit_room,
            'visit_note' => $request->visit_note,
        ]);

        return redirect()->route('visits.index')->with('success', 'Wizyta została dodana.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $visit = Visit::findOrFail($id);
        $doctors = User::where('role', 'lekarz')->get();
        $patients = Patients::all();

        return view('visits.edit', compact('visit', 'doctors', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date|after:now',
            'visit_room' => 'required|string|max:255',
            'visit_note' => 'nullable|string',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->update($request->only([
            'visit_date', 'visit_room', 'visit_note', 'doctor_id', 'patient_id'
        ]));

        return redirect()->route('visits.index')->with('success', 'Wizyta została zaktualizowana.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Visit::destroy($id);
        return redirect()->route('visits.index')->with('success', 'Wizyta została anulowana.');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'visit_date' => 'required|date|after:now',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->visit_date = $request->visit_date;
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Termin wizyty został zmieniony.');
    }
}



