<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\GrandPrix;
use Illuminate\Support\Facades\DB;

class DiagramController extends Controller
{
    public function index(Request $request)
    {
        $selectedTeam = $request->get('team');
        $selectedYear = $request->get('year');
        
        $dnfData = $this->getDNFDataByTeam($selectedTeam, $selectedYear);
        $locationData = $this->getGrandPrixLocationData();
        
        // Szűrési opciók: csapatok és évek lekérése
        $teams = Result::select('team')->distinct()->orderBy('team')->pluck('team');
        $years = Result::selectRaw('YEAR(race_date) as year')->distinct()->orderBy('year', 'desc')->pluck('year');
        
        return view('diagrams.index', compact('dnfData', 'locationData', 'teams', 'years', 'selectedTeam', 'selectedYear'));
    }

    private function getDNFDataByTeam($selectedTeam = null, $selectedYear = null)
    {
        $query = Result::where(function($q) {
                $q->whereNull('position')->orWhere('position', 0);
            })
            ->whereNotNull('team')
            ->where('team', '!=', '');
            
        if ($selectedTeam) {
            $query->where('team', $selectedTeam);
        }
        
        if ($selectedYear) {
            $query->whereYear('race_date', $selectedYear);
        }
        
        $dnfResults = $query->select('team', 'issue', 'engine', DB::raw('COUNT(*) as dnf_count'))
            ->groupBy('team', 'issue', 'engine')
            ->orderBy('team')
            ->get();

        $teams = $dnfResults->pluck('team')->unique()->values();
        $issues = $dnfResults->pluck('issue')->unique()->filter()->values();
        $engines = $dnfResults->pluck('engine')->unique()->values();

        $teamDNFCounts = $dnfResults->groupBy('team')->map(function ($teamResults) {
            return $teamResults->sum('dnf_count');
        });

        // Részletes DNF adatok a táblázathoz - külön query egyedi rekordokhoz
        $detailedQuery = Result::where(function($q) {
                $q->whereNull('position')->orWhere('position', 0);
            })
            ->whereNotNull('team')
            ->where('team', '!=', '');
        
        if ($selectedTeam) {
            $detailedQuery->where('team', $selectedTeam);
        }
        
        if ($selectedYear) {
            $detailedQuery->whereYear('race_date', $selectedYear);
        }
        
        $detailedDNFs = $detailedQuery->select('team', 'race_date', 'issue', 'engine')
            ->orderBy('race_date', 'desc')
            ->get();

        return [
            'teams' => $teams,
            'teamDNFCounts' => $teamDNFCounts,
            'issues' => $issues,
            'engines' => $engines,
            'detailedData' => $detailedDNFs,
            'isFiltered' => !empty($selectedTeam) || !empty($selectedYear)
        ];
    }

    private function getGrandPrixLocationData()
    {
        $locationCounts = GrandPrix::select('location', DB::raw('COUNT(*) as race_count'))
            ->groupBy('location')
            ->orderBy('race_count', 'desc')
            ->get();

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
