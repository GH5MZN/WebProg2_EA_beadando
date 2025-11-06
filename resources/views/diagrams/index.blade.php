@extends('layouts.landed-layout')

@section('title', 'Diagramok')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Diagramok a múltbeli nagydíjakról</h1>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Szűrők</h5>
                        <form method="GET" action="{{ route('diagrams') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="team" class="form-label">Csapat</label>
                                    <select name="team" id="team" class="form-select">
                                        <option value="">Összes csapat</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team }}" {{ $selectedTeam == $team ? 'selected' : '' }}>{{ $team }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="form-label">Év</label>
                                    <select name="year" id="year" class="form-select">
                                        <option value="">Összes év</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Szűrés</button>
                                    <a href="{{ route('diagrams') }}" class="btn btn-outline-secondary">Törlés</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" onclick="showChart('radar')" id="radarBtn">
                        DNF Statisztikák
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="showChart('bar')" id="barBtn">
                        Helyszín Gyakoriság
                    </button>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="badge bg-primary fs-6">
                    @if($selectedTeam || $selectedYear)
                        Szűrve: 
                        @if($selectedTeam) {{ $selectedTeam }} @endif
                        @if($selectedYear) {{ $selectedYear }} @endif
                    @else
                        Adatok: {{ $dnfData['detailedData']->count() }} DNF rekord
                    @endif
                </div>
            </div>
        </div>

        <div id="radarChart" class="chart-container">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Csapatok DNF Statisztikái</h2>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="dnfRadarChart"></canvas>
                        </div>
                        <div class="col-md-4">
                            <h5>DNF Részletek</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Csapat</th>
                                            <th>DNF szám</th>
                                            <th>Fő problémák</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dnfData['teamDNFCounts'] as $team => $count)
                                        <tr>
                                            <td class="fw-bold">{{ $team }}</td>
                                            <td><span class="badge bg-danger">{{ $count }}</span></td>
                                            <td>
                                                @php
                                                    $teamIssues = $dnfData['detailedData']->where('team', $team)->pluck('issue')->filter()->unique();
                                                @endphp
                                                <small>{{ $teamIssues->implode(', ') ?: 'N/A' }}</small>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart - Location Frequency -->
        <div id="barChart" class="chart-container" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Nagydíj helyszínek statisztikája</h2>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="locationBarChart"></canvas>
                        </div>
                        <div class="col-md-4">
                 
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Ország</th>
                                            <th>Rendezett versenyek</th>
                                            <th>Nagydíj neve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($locationData['details'] as $detail)
                                        <tr>
                                            <td class="fw-bold">{{ $detail->location }}</td>
                                            <td><span class="badge bg-primary">{{ $detail->unique_races }}</span></td>
                                            <td><small>{{ $detail->name }}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Summary -->
        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div class="chart-stat-number">{{ $dnfData['teams']->count() }}</div>
                    <h3>Csapatok</h3>
                    <p class="text-muted">DNF rekordokkal</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div class="chart-stat-number">{{ $dnfData['detailedData']->sum('dnf_count') }}</div>
                    <h3>Összes DNF</h3>
                    <p class="text-muted">Eredmény rekordokban</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div class="chart-stat-number">{{ $locationData['locations']->count() }}</div>
                    <h3>Helyszínek</h3>
                    <p class="text-muted">Grand Prix lokációk</p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="btn btn-outline-f1">
                ← Vissza a főoldalra
            </a>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const dnfData = @json($dnfData);
const locationData = @json($locationData);

let radarChart, barChart;

document.addEventListener('DOMContentLoaded', function() {
    initRadarChart();
    initBarChart();
});

function showChart(chartType) {
    document.querySelectorAll('.chart-container').forEach(container => {
        container.style.display = 'none';
    });
    
    document.querySelectorAll('[id$="Btn"]').forEach(btn => {
        btn.className = btn.className.replace('btn-primary', 'btn-outline-primary');
    });
    
    if (chartType === 'radar') {
        document.getElementById('radarChart').style.display = 'block';
        document.getElementById('radarBtn').className = 
            document.getElementById('radarBtn').className.replace('btn-outline-primary', 'btn-primary');
    } else if (chartType === 'bar') {
        document.getElementById('barChart').style.display = 'block';
        document.getElementById('barBtn').className = 
            document.getElementById('barBtn').className.replace('btn-outline-primary', 'btn-primary');
    }
}

function initRadarChart() {
    const ctx = document.getElementById('dnfRadarChart');
    if (!ctx) return;
    
    const context = ctx.getContext('2d');
    
    if (radarChart) {
        radarChart.destroy();
    }
    
    const teams = dnfData.teams || [];
    const dnfCounts = teams.map(team => dnfData.teamDNFCounts[team] || 0);
    
    radarChart = new Chart(context, {
        type: 'radar',
        data: {
            labels: teams,
            datasets: [{
                label: 'DNF Szám',
                data: dnfCounts,
                backgroundColor: 'rgba(255, 107, 107, 0.2)',
                borderColor: 'rgba(255, 107, 107, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(255, 107, 107, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(255, 107, 107, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#666'
                    },
                    grid: {
                        color: '#ddd'
                    }
                }
            }
        }
    });
}

function initBarChart() {
    const ctx = document.getElementById('locationBarChart');
    if (!ctx) return;
    
    const context = ctx.getContext('2d');
    
    if (barChart) {
        barChart.destroy();
    }
    
    const locations = locationData.locations || [];
    const raceCounts = locationData.raceCounts || [];
    
    barChart = new Chart(context, {
        type: 'bar',
        data: {
            labels: locations,
            datasets: [{
                label: 'Grand Prix Szám',
                data: raceCounts,
                backgroundColor: [
                    'rgba(255, 107, 107, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)',
                    'rgba(83, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 107, 107, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#666'
                    },
                    grid: {
                        color: '#ddd'
                    }
                },
                x: {
                    ticks: {
                        color: '#666'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>
@endsection
