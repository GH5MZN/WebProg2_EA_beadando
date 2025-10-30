@extends('layouts.app-layout')

@section('title', $pilot['nev'] . ' - F1 Pilóta Profil')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Driver Header -->
        <div class="hero-section">
            <h1 class="hero-title">🏎️ {{ $pilot['nev'] }}</h1>
            <p class="lead">Pilóta ID: {{ $pilot['az'] }} | {{ $pilot['nemzet'] }}</p>
        </div>

        <!-- Driver Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Nem</h6>
                    <p class="h5 mb-0">{{ $pilot['nem'] == 'M' ? '👨 Férfi' : '👩 Nő' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Születési dátum</h6>
                    <p class="h5 mb-0">{{ $pilot['szuldat'] ?: 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Nemzetiség</h6>
                    <p class="h5 mb-0">{{ $pilot['nemzet'] }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Verseny eredmények</h6>
                    <p class="h5 mb-0">{{ count($pilotResults) }} db</p>
                </div>
            </div>
        </div>

        <!-- Race Results -->
        @if(count($pilotResults) > 0)
        <div class="card-f1">
            <h3 class="text-f1 mb-4">Legutóbbi verseny eredmények</h3>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-f1">
                    <thead>
                        <tr>
                            <th>Dátum</th>
                            <th>Pozíció</th>
                            <th>Probléma</th>
                            <th>Csapat</th>
                            <th>Autó típus</th>
                            <th>Motor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pilotResults as $result)
                        <tr>
                            <td>{{ $result['datum'] }}</td>
                            <td>
                                @if($result['helyezes'])
                                    @php
                                        $badgeClass = 'bg-f1';
                                        if($result['helyezes'] <= 3) $badgeClass = 'bg-success';
                                        elseif($result['helyezes'] <= 10) $badgeClass = 'bg-warning';
                                        else $badgeClass = 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        P{{ $result['helyezes'] }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">DNF</span>
                                @endif
                            </td>
                            <td>{{ $result['hiba'] ?: '-' }}</td>
                            <td>{{ $result['csapat'] }}</td>
                            <td>{{ $result['tipus'] }}</td>
                            <td>{{ $result['motor'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="card-f1 text-center">
            <h3 class="text-f1">Nincsenek verseny eredmények</h3>
            <p>Ez a pilóta még nem vett részt versenyeken.</p>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-5">
            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">← Vissza a pilótákhoz</a>
            <div>
                <a href="{{ route('pilots.edit', $pilot['az']) }}" class="btn btn-outline-f1">Pilóta szerkesztése</a>
                <a href="{{ route('home') }}" class="btn btn-f1">Főoldal</a>
            </div>
        </div>
    </div>
</div>
@endsection