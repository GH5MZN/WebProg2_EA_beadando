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
        // Pilóták lekérése szűréssel (txt fájlból betöltve)
        $pilotsQuery = Pilot::query();
        
        // Név keresés
        if ($request->filled('search')) {
            $pilotsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Nemzetiség szűrés
        if ($request->filled('nationality')) {
            $pilotsQuery->where('nationality', $request->nationality);
        }
        
        $pilots = $pilotsQuery->orderBy('az')->get();
        
        // Egyedi nemzetiségek lekérése a szűrő dropdown-hoz
        $nationalities = Pilot::whereNotNull('nationality')
                              ->distinct()
                              ->orderBy('nationality')
                              ->pluck('nationality');

        // Grand Prix versenyek lekérése szűréssel (txt fájlból betöltve)
        $grandPrixQuery = GrandPrix::query();
        
        $hasFilter = false;
        
        // Év szűrés
        if ($request->filled('year')) {
            $grandPrixQuery->whereYear('race_date', $request->year);
            $hasFilter = true;
        }
        
        // Helyszín szűrés
        if ($request->filled('location')) {
            $grandPrixQuery->where('location', 'like', '%' . $request->location . '%');
            $hasFilter = true;
        }
        
        // Rendezés: ha van szűrés, akkor dátum szerint növekvő, különben ID szerint
        if ($hasFilter) {
            $grandPrix = $grandPrixQuery->orderBy('race_date', 'asc')->get();
        } else {
            $grandPrix = $grandPrixQuery->orderBy('id', 'asc')->get();
        }
        
        // Egyedi évek lekérése a szűrő dropdown-hoz
        $years = GrandPrix::selectRaw('YEAR(race_date) as year')
                          ->distinct()
                          ->orderBy('year', 'desc')
                          ->pluck('year');

        // Eredmények lekérése
        $results = Result::with(['pilot', 'grandPrix'])
                         ->orderBy('race_date', 'desc')
                         ->get();
        
        return view('database.index', compact('pilots', 'nationalities', 'grandPrix', 'years', 'results'));
    }
}