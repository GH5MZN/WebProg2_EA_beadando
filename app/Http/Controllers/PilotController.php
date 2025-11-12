<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilot;
use App\Models\PilotCurrent;
use App\Models\Result;
use App\Models\GrandPrix;

class PilotController extends Controller
{
    public function index(Request $request)
    {
        $query = PilotCurrent::query();
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('nationality')) {
            $query->where('nationality', $request->nationality);
        }
        
        $pilots = $query->orderBy('pilot_id')->paginate(50);
        
        $nationalities = PilotCurrent::whereNotNull('nationality')
                                    ->distinct()
                                    ->orderBy('nationality')
                                    ->pluck('nationality');
        
        return view('pilots.index', compact('pilots', 'nationalities'));
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
        
        $pilotResults = Result::where('pilotaaz', $id)
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
        
        $hasResults = Result::where('pilotaaz', $id)->exists();
        
        if ($hasResults) {
            return redirect()->route('pilots.index')
                           ->with('error', 'Nem törölhető a pilóta, mert vannak eredményei!');
        }
        
        $pilot->delete();

        return redirect()->route('pilots.index')
                        ->with('success', 'Pilóta sikeresen törölve!');
    }
}