@extends('layouts.landed-layout')

@section('title', 'Adatbázis Menü - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Adatbázisok</h1>
        </div>

        <!-- Pilots Section -->
        <div class="card-f1 mb-5">
            <h2 class="text-f1 mb-4">Jelenlegi Pilóták (PilotsCurrent tábla)</h2>
            @if($pilots->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th class="d-none d-md-table-cell">ID</th>
                                <th>Név</th>
                                <th class="d-none d-lg-table-cell">Csapat</th>
                                <th class="d-none d-lg-table-cell">Nem</th>
                                <th class="d-none d-lg-table-cell">Nemzetiség</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                            <tr>
                                <td class="d-none d-md-table-cell"><span class="badge bg-secondary">{{ $pilot->pilot_id }}</span></td>
                                <td class="fw-bold">{{ $pilot->name ?? 'N/A' }}</td>
                                <td class="d-none d-lg-table-cell">
                                    @if($pilot->team)
                                        <span class="badge bg-primary">{{ $pilot->team }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell">{{ $pilot->gender ?? '-' }}</td>
                                <td class="d-none d-lg-table-cell">{{ $pilot->nationality ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted text-center">Összes jelenlegi pilóta megjelenítve ({{ $pilots->count() }} db)</p>
            @else
                <div class="text-center py-3">
                    <p>Nincsenek pilóták az adatbázisban.</p>
                </div>
            @endif
        </div>

        <!-- Grand Prix Section -->
        <div class="card-f1 mb-5">
            <h2 class="text-f1 mb-4">Grand Prix versenyek (Grand Prix tábla)</h2>
            @if($grandPrix->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th>Verseny</th>
                                <th class="d-none d-lg-table-cell">Helyszín</th>
                                <th class="d-none d-md-table-cell">Dátum</th>
                                <th class="d-none d-xl-table-cell">Évszak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grandPrix as $gp)
                            <tr>
                                <td class="fw-bold">{{ $gp->race_name }}</td>
                                <td class="d-none d-lg-table-cell">{{ $gp->location }}</td>
                                <td class="d-none d-md-table-cell">{{ $gp->race_date->format('Y.m.d') }}</td>
                                <td class="d-none d-xl-table-cell"><span class="badge bg-f1">{{ $gp->season }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted text-center">Összes verseny megjelenítve ({{ $grandPrix->count() }} db)</p>
            @else
                <div class="text-center py-3">
                    <p>Nincsenek versenyek az adatbázisban.</p>
                </div>
            @endif
        </div>

        <!-- Results Section -->
        <div class="card-f1 mb-5">
            <h2 class="text-f1 mb-4">Versenyeredmények (Results tábla)</h2>
            @if($results->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th class="d-none d-md-table-cell">Dátum</th>
                                <th>Pilóta</th>
                                <th class="d-none d-lg-table-cell">Hely</th>
                                <th class="d-none d-xl-table-cell">Csapat</th>
                                <th class="d-none d-xl-table-cell">Autó</th>
                                <th class="d-none d-xl-table-cell">Motor</th>
                                <th class="d-none d-lg-table-cell">Probléma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $result->race_date->format('Y.m.d') }}</td>
                                <td class="fw-bold">{{ $result->pilot->name ?? 'N/A' }}</td>
                                <td class="d-none d-lg-table-cell">
                                    @if($result->position)
                                        <span class="badge bg-success">{{ $result->position }}.</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td class="d-none d-xl-table-cell">{{ $result->team }}</td>
                                <td class="d-none d-xl-table-cell">{{ $result->car_type }}</td>
                                <td class="d-none d-xl-table-cell">{{ $result->engine }}</td>
                                <td class="d-none d-lg-table-cell">
                                    @if($result->issue)
                                        <small class="text-danger">{{ $result->issue }}</small>
                                    @else
                                        <small class="text-success">OK</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted text-center">Összes eredmény megjelenítve ({{ $results->count() }} db)</p>
            @else
                <div class="text-center py-3">
                    <p>Nincsenek eredmények az adatbázisban.</p>
                </div>
            @endif
        </div>

        <!-- Statistics -->
        <div class="row">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Összes pilóta</h4>
                    <h2 class="display-4">{{ $pilots->count() }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Összes verseny</h4>
                    <h2 class="display-4">{{ $grandPrix->count() }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Összes eredmény</h4>
                    <h2 class="display-4">{{ $results->count() }}</h2>
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
@endsection
