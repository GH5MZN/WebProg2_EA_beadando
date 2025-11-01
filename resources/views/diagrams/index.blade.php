@extends('layouts.app-layout')

@section('title', 'F1 Statisztikai Diagramok - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">📊 F1 Statisztikai Diagramok</h1>
            <p class="lead">Interaktív diagramok a Forma-1 adatbázis alapján<br />
            Verseny eredmények és statisztikák vizualizálása</p>
        </div>

        <!-- Chart Controls -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-f1" onclick="showChart('radar')" id="radarBtn">
                        🎯 DNF Statisztikák
                    </button>
                    <button type="button" class="btn btn-outline-f1" onclick="showChart('bar')" id="barBtn">
                        📊 Helyszín Gyakoriság
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="badge bg-f1 fs-6">
                    Adatok: {{ $dnfData['detailedData']->count() }} DNF rekord
                </div>
            </div>
        </div>

        <!-- Radar Chart - DNF Statistics -->
        <div id="radarChart" class="chart-container">
            <div class="card-f1">
                <h2 class="text-f1 mb-4 text-center">🎯 Csapatok DNF Statisztikái</h2>
                <p class="text-center text-muted mb-4">
                    Radar diagram a csapatok Did Not Finish (DNF) eredményeiről
                </p>
                
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="dnfRadarChart" width="400" height="300"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-f1">📋 DNF Részletek</h5>
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
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

        <!-- Bar Chart - Location Frequency -->
        <div id="barChart" class="chart-container" style="display: none;">
            <div class="card-f1">
                <h2 class="text-f1 mb-4 text-center">📊 Grand Prix Helyszínek Gyakorisága</h2>
                <p class="text-center text-muted mb-4">
                    Oszlopdiagram arról, hogy melyik helyszínen hányszor rendeztek Grand Prix-t
                </p>
                
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="locationBarChart" width="400" height="300"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h5 class="text-f1">🏁 Helyszín Részletek</h5>
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Helyszín</th>
                                        <th>Versenyek</th>
                                        <th>Nevezetességek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locationData['details'] as $detail)
                                    <tr>
                                        <td class="fw-bold">{{ $detail->location }}</td>
                                        <td><span class="badge bg-f1">{{ $detail->unique_races }}</span></td>
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

        <!-- Statistics Summary -->
        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ $dnfData['teams']->count() }}</div>
                    <h3>Csapatok</h3>
                    <p class="text-muted">DNF rekordokkal</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ $dnfData['detailedData']->sum('dnf_count') }}</div>
                    <h3>Összes DNF</h3>
                    <p class="text-muted">Eredmény rekordokban</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ $locationData['locations']->count() }}</div>
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
// Chart data from PHP
const dnfData = @json($dnfData);
const locationData = @json($locationData);

// Chart instances
let radarChart, barChart;

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    initRadarChart();
    initBarChart();
});

// Show specific chart
function showChart(chartType) {
    // Hide all charts
    document.querySelectorAll('.chart-container').forEach(container => {
        container.style.display = 'none';
    });
    
    // Remove active state from all buttons
    document.querySelectorAll('[id$="Btn"]').forEach(btn => {
        btn.className = btn.className.replace('btn-f1', 'btn-outline-f1');
    });
    
    // Show selected chart and set active button
    if (chartType === 'radar') {
        document.getElementById('radarChart').style.display = 'block';
        document.getElementById('radarBtn').className = 
            document.getElementById('radarBtn').className.replace('btn-outline-f1', 'btn-f1');
    } else if (chartType === 'bar') {
        document.getElementById('barChart').style.display = 'block';
        document.getElementById('barBtn').className = 
            document.getElementById('barBtn').className.replace('btn-outline-f1', 'btn-f1');
    }
}

// Initialize Radar Chart
function initRadarChart() {
    const ctx = document.getElementById('dnfRadarChart').getContext('2d');
    
    // Prepare data for radar chart
    const teams = dnfData.teams;
    const dnfCounts = teams.map(team => dnfData.teamDNFCounts[team] || 0);
    
    radarChart = new Chart(ctx, {
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
            plugins: {
                title: {
                    display: true,
                    text: 'Csapatok DNF Statisztikái',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
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
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Initialize Bar Chart
function initBarChart() {
    const ctx = document.getElementById('locationBarChart').getContext('2d');
    
    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: locationData.locations,
            datasets: [{
                label: 'Grand Prix Szám',
                data: locationData.raceCounts,
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
            plugins: {
                title: {
                    display: true,
                    text: 'Grand Prix Helyszínek Gyakorisága',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}
</script>
@endsection