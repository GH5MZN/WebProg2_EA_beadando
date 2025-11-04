<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PilotCurrent;
use App\Models\Result;
use App\Models\GrandPrix;

class PilotController extends Controller
{


    public function index()
    {
        $pilots = PilotCurrent::orderBy('pilot_id')->get();
        
        return view('pilots.index', compact('pilots'));
    }

    public function create()
    {
        return view('pilots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'team' => 'nullable|string|max:100'
        ]);

        PilotCurrent::create($validated);

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen hozzáadva!');
    }

    public function show(string $id)
    {
        $pilot = PilotCurrent::where('pilot_id', $id)->firstOrFail();
        
        $pilotResults = Result::where('pilot_id', $id)
                              ->with('grandPrix')
                              ->orderBy('race_date', 'desc')
                              ->paginate(10);
        
        return view('pilots.show', compact('pilot', 'pilotResults'));
    }

    public function edit(string $id)
    {
        $pilot = PilotCurrent::where('pilot_id', $id)->firstOrFail();
        
        return view('pilots.edit', compact('pilot'));
    }

    public function update(Request $request, string $id)
    {
        $pilot = PilotCurrent::where('pilot_id', $id)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'team' => 'nullable|string|max:100'
        ]);

        $pilot->update($validated);

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen módosítva!');
    }

    public function destroy(string $id)
    {
        $pilot = PilotCurrent::where('pilot_id', $id)->firstOrFail();
        
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