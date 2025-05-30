<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Hospitalisation;
use App\Models\Research;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Research::query();

        if ($request->filled('status')) {
            $statusMap = [
                'done' => 'Zakończone',
                'ongoing' => 'W toku',
                'canceled' => 'Anulowane',
            ];
            $query->where('status', $statusMap[$request->status] ?? $request->status);
        }

        if ($request->filled('type')) {
            $query->where('research_type', $request->type);
        }
        $query->orderBy('date_of_research', 'desc');
        $researches = $query->with('hospitalisation.patient')->get();

        return view('research.research', compact('researches'));
    }




    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $hospitalisations = Hospitalisation::with('patient')
            ->get()
            ->sortBy(fn($h) => $h->patient->last_name);
        return view('research.create', compact('hospitalisations'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitalisations,id',
            'research_type' => 'required|string',
            'note' => 'nullable|string',
        ]);

        Research::create([
            'hospital_id' => $request->hospital_id,
            'research_type' => $request->research_type,
            'note' => $request->note,
            'date_of_research' => Carbon::now()->toDateString(), // dzisiejsza data
            'status' => 'W toku', // automatyczny status
            'result' => '', // pusty string
        ]);

        return redirect()->route('research.index')->with('success', 'Badanie zostało dodane.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Research $research)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Research $research)
    {
        $hospitalisations = Hospitalisation::with('patient')
            ->get()
            ->sortBy(fn($h) => $h->patient->last_name);

        return view('research.edit', compact('research', 'hospitalisations'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Research $research)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitalisations,id',
            'research_type' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $research->update([
            'hospital_id' => $request->hospital_id,
            'research_type' => $request->research_type,
            'note' => $request->note,
        ]);

        return redirect()->route('research.index')->with('success', 'Badanie zostało zaktualizowane.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Research $research)
    {
        $research->delete();
        return redirect()->route('research.index')->with('success', 'Badanie zostało usunięte.');
    }
    public function completeForm($id)
    {
        $research = Research::findOrFail($id);
        return view('research.complete', compact('research'));
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'result' => 'required|string',
        ]);

        $research = Research::findOrFail($id);
        $research->result = $request->result;
        $research->status = 'Zakończone';
        $research->save();

        return redirect()->route('research.index')->with('success', 'Badanie zostało zakończone.');
    }

    public function cancel($id)
    {
        $research = Research::findOrFail($id);
        $research->status = 'Anulowane';
        $research->save();

        return redirect()->route('research.index')->with('success', 'Badanie zostało anulowane.');
    }
}
