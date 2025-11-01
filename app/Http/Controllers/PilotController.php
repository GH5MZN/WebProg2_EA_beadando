<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilot;
use App\Models\Result;
use App\Models\GrandPrix;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pilots = Pilot::orderBy('pilot_id')->paginate(20);
        
        return view('pilots.index', compact('pilots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pilots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pilot_id' => 'required|string|max:10|unique:pilots,pilot_id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'birth_date' => 'required|date|before:today',
            'nationality' => 'required|string|max:100'
        ]);

        Pilot::create($validated);

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen hozzáadva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pilot = Pilot::where('pilot_id', $id)->firstOrFail();
        
        // Get pilot's results with related Grand Prix data
        $pilotResults = Result::where('pilot_id', $id)
                              ->with('grandPrix')
                              ->orderBy('race_date', 'desc')
                              ->paginate(10);
        
        return view('pilots.show', compact('pilot', 'pilotResults'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pilot = Pilot::where('pilot_id', $id)->firstOrFail();
        
        return view('pilots.edit', compact('pilot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pilot = Pilot::where('pilot_id', $id)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'birth_date' => 'required|date|before:today',
            'nationality' => 'required|string|max:100'
        ]);

        $pilot->update($validated);

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen módosítva!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pilot = Pilot::where('pilot_id', $id)->firstOrFail();
        
        // Check if pilot has results (optional safety check)
        $hasResults = Result::where('pilot_id', $id)->exists();
        
        if ($hasResults) {
            return redirect()->route('pilots.index')
                           ->with('error', 'Nem törölhető a pilóta, mert vannak eredményei!');
        }
        
        $pilot->delete();

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen törölve!');
    }
}