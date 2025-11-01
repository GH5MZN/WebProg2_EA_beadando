<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\GrandPrix;
use Illuminate\Support\Facades\DB;

class DiagramController extends Controller
{
    /**
     * Display the diagrams page.
     */
    public function index()
    {
        // 1. DNF adatok csapatok szerint (Radar Chart)
        $dnfData = $this->getDNFDataByTeam();
        
        // 2. Grand Prix helyszínek gyakorisága (Bar Chart)
        $locationData = $this->getGrandPrixLocationData();
        
        return view('diagrams.index', compact('dnfData', 'locationData'));
    }

    /**
     * Get DNF data by teams for radar chart
     */
    private function getDNFDataByTeam()
    {
        // DNF eredmények csapatok szerint csoportosítva
        $dnfResults = Result::whereNull('position')
            ->orWhere('position', 0)
            ->select('team', 'issue', 'engine', DB::raw('COUNT(*) as dnf_count'))
            ->groupBy('team', 'issue', 'engine')
            ->orderBy('team')
            ->get();

        // Adatok strukturálása Chart.js-hez
        $teams = $dnfResults->pluck('team')->unique()->values();
        $issues = $dnfResults->pluck('issue')->unique()->filter()->values();
        $engines = $dnfResults->pluck('engine')->unique()->values();

        // Csapatok DNF számainak összesítése
        $teamDNFCounts = $dnfResults->groupBy('team')->map(function ($teamResults) {
            return $teamResults->sum('dnf_count');
        });

        return [
            'teams' => $teams,
            'teamDNFCounts' => $teamDNFCounts,
            'issues' => $issues,
            'engines' => $engines,
            'detailedData' => $dnfResults
        ];
    }

    /**
     * Get Grand Prix location frequency data for bar chart
     */
    private function getGrandPrixLocationData()
    {
        // Grand Prix-ok helyszín szerint csoportosítva
        $locationCounts = GrandPrix::select('location', DB::raw('COUNT(*) as race_count'))
            ->groupBy('location')
            ->orderBy('race_count', 'desc')
            ->get();

        // További részletek - eredményekkel való összekapcsolás
        $locationDetails = GrandPrix::select('location', 'name', DB::raw('COUNT(DISTINCT grand_prix.race_date) as unique_races'))
            ->leftJoin('results', 'grand_prix.race_date', '=', 'results.race_date')
            ->groupBy('location', 'name')
            ->orderBy('unique_races', 'desc')
            ->get();

        return [
            'locations' => $locationCounts->pluck('location'),
            'raceCounts' => $locationCounts->pluck('race_count'),
            'details' => $locationDetails
        ];
    }
}
