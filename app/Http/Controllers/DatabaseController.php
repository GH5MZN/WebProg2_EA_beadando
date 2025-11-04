<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PilotCurrent;
use App\Models\GrandPrix;
use App\Models\Result;

class DatabaseController extends Controller
{
    public function index()
    {
        // 3 tábla összes adatának lekérése ORM-mel
        $pilots = PilotCurrent::orderBy('pilot_id')->get();
        $grandPrix = GrandPrix::orderBy('race_date', 'desc')->get();
        $results = Result::with(['pilot', 'grandPrix'])
                         ->orderBy('race_date', 'desc')
                         ->get();
        
        return view('database.index', compact('pilots', 'grandPrix', 'results'));
    }
}