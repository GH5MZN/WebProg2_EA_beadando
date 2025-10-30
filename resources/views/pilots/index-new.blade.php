@extends('layouts.app-layout')

@section('title', 'F1 Adatbázis - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">F1 Bajnokság Adatbázis</h1>
            <p class="lead">Fedezd fel a Forma-1 teljes történetét<br />
            Pilóták, eredmények és Grand Prix adatok archívumunkból</p>
        </div>

        <!-- Statistics Overview -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ count($pilots) }}</div>
                    <h3>Pilóták</h3>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ count($results) }}</div>
                    <h3>Eredmények</h3>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2.5em; color: #ff6b6b;">{{ count($gps) }}</div>
                    <h3>Grand Prix</h3>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="text-center mb-4">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-f1" onclick="showTab('drivers')" id="driversBtn">
                    👨‍🏆 Pilóták
                </button>
                <button type="button" class="btn btn-outline-f1" onclick="showTab('results')" id="resultsBtn">
                    🏆 Eredmények
                </button>
                <button type="button" class="btn btn-outline-f1" onclick="showTab('grandprix')" id="grandprixBtn">
                    🏁 Grand Prix
                </button>
            </div>
        </div>

        <!-- Drivers Tab -->
        <div id="driversTab" class="tab-content">
            <div class="card-f1">
                <h2 class="text-f1 mb-4 text-center">🏎️ F1 Pilóták Adatbázis</h2>
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pilóta neve</th>
                                <th>Nem</th>
                                <th>Születési dátum</th>
                                <th>Nemzetiség</th>
                                <th>Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pilots as $pilot)
                            <tr>
                                <td>{{ $pilot->pilot_id }}</td>
                                <td class="fw-bold">{{ $pilot->name }}</td>
                                <td>{{ $pilot->gender == 'M' ? '👨 Férfi' : '👩 Nő' }}</td>
                                <td>{{ $pilot->birth_date->format('Y.m.d') }}</td>
                                <td>{{ $pilot->nationality }}</td>
                                <td>
                                    <a href="{{ route('pilots.show', $pilot->pilot_id) }}" 
                                       class="btn btn-f1 btn-sm">Megtekintés</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Nincsenek pilóták az adatbázisban</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Results Tab -->
        <div id="resultsTab" class="tab-content" style="display: none;">
            <div class="card-f1">
                <h2 class="text-f1 mb-4 text-center">🏆 Verseny Eredmények</h2>
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th>Dátum</th>
                                <th>Pilóta ID</th>
                                <th>Pozíció</th>
                                <th>Probléma</th>
                                <th>Csapat</th>
                                <th>Autó típus</th>
                                <th>Motor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $result)
                            <tr>
                                <td>{{ $result->race_date->format('Y.m.d') }}</td>
                                <td class="fw-bold">{{ $result->pilot_id }}</td>
                                <td>
                                    @if($result->position)
                                        <span class="badge bg-f1">{{ $result->position }}</span>
                                    @else
                                        <span class="badge bg-secondary">DNF</span>
                                    @endif
                                </td>
                                <td>{{ $result->issue ?: '-' }}</td>
                                <td>{{ $result->team }}</td>
                                <td>{{ $result->car_type }}</td>
                                <td>{{ $result->engine }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Nincsenek eredmények az adatbázisban</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Grand Prix Tab -->
        <div id="grandprixTab" class="tab-content" style="display: none;">
            <div class="card-f1">
                <h2 class="text-f1 mb-4 text-center">🏁 Grand Prix Naptár</h2>
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th>Dátum</th>
                                <th>Grand Prix</th>
                                <th>Helyszín</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gps as $gp)
                            <tr>
                                <td>{{ $gp->race_date->format('Y.m.d') }}</td>
                                <td class="fw-bold">🏆 {{ $gp->name }} GP</td>
                                <td>📍 {{ $gp->location }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Nincsenek Grand Prix adatok</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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

<script>
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remove active state from all buttons
        document.querySelectorAll('[id$="Btn"]').forEach(btn => {
            btn.className = btn.className.replace('btn-f1', 'btn-outline-f1');
        });
        
        // Show selected tab and set active button
        if (tabName === 'drivers') {
            document.getElementById('driversTab').style.display = 'block';
            document.getElementById('driversBtn').className = 
                document.getElementById('driversBtn').className.replace('btn-outline-f1', 'btn-f1');
        } else if (tabName === 'results') {
            document.getElementById('resultsTab').style.display = 'block';
            document.getElementById('resultsBtn').className = 
                document.getElementById('resultsBtn').className.replace('btn-outline-f1', 'btn-f1');
        } else if (tabName === 'grandprix') {
            document.getElementById('grandprixTab').style.display = 'block';
            document.getElementById('grandprixBtn').className = 
                document.getElementById('grandprixBtn').className.replace('btn-outline-f1', 'btn-f1');
        }
    }
</script>
@endsection