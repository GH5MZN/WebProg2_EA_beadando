<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilot;
use App\Models\GrandPrix;
use App\Models\Result;

class DatabaseController extends Controller
{
    public function index(Request $request)
    {
        $pilotsQuery = Pilot::query();
        
        if ($request->filled('search')) {
            $pilotsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('nationality')) {
            $pilotsQuery->where('nationality', $request->nationality);
        }
        
        $pilots = $pilotsQuery->orderBy('az')->get();
        
        $nationalities = Pilot::whereNotNull('nationality')
                              ->distinct()
                              ->orderBy('nationality')
                              ->pluck('nationality');

        $grandPrixQuery = GrandPrix::query();
        
        $hasFilter = false;
        
        if ($request->filled('year')) {
            $grandPrixQuery->whereYear('race_date', $request->year);
            $hasFilter = true;
        }
        
        if ($request->filled('location')) {
            $grandPrixQuery->where('location', 'like', '%' . $request->location . '%');
            $hasFilter = true;
        }
        
        if ($hasFilter) {
            $grandPrix = $grandPrixQuery->orderBy('race_date', 'asc')->get();
        } else {
            $grandPrix = $grandPrixQuery->orderBy('id', 'asc')->get();
        }
        
        $years = GrandPrix::selectRaw('YEAR(race_date) as year')
                          ->distinct()
                          ->orderBy('year', 'desc')
                          ->pluck('year');

        $results = Result::with(['pilot', 'grandPrix'])
                         ->orderBy('race_date', 'desc')
                         ->get();
        
        return view('database.index', compact('pilots', 'nationalities', 'grandPrix', 'years', 'results'));
    }
}