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
        // Get data from database instead of txt files
        $pilots = Pilot::orderBy('pilot_id')->limit(100)->get();
        $results = Result::with('pilot')->orderBy('race_date', 'desc')->limit(50)->get();
        $gps = GrandPrix::orderBy('race_date', 'desc')->limit(50)->get();
        
        // Check which route we're on
        if (request()->route()->getName() === 'test') {
            return view('test', compact('pilots', 'results', 'gps'));
        }
        
        return view('pilots.index', compact('pilots', 'results', 'gps'));
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
        // For demo purposes, just redirect back with success message
        return redirect()->route('pilots.index')->with('success', 'Pilot added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pilot = Pilot::where('pilot_id', $id)->firstOrFail();
        
        // Get pilot's results
        $pilotResults = Result::where('pilot_id', $id)
                              ->orderBy('race_date', 'desc')
                              ->limit(10)
                              ->get();
        
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
        return redirect()->route('pilots.index')->with('success', 'Pilot updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('pilots.index')->with('success', 'Pilot deleted successfully!');
    }
}