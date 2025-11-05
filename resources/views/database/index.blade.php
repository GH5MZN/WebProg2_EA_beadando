@extends('layouts.landed-layout')

@section('title', 'Bajnokok Csarnoka')

@push('styles')
<style>
.scrollable-table {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid rgba(255, 107, 107, 0.3);
    border-radius: 10px;
}

.scrollable-table::-webkit-scrollbar {
    width: 8px;
}

.scrollable-table::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.scrollable-table::-webkit-scrollbar-thumb {
    background: #ff6b6b;
    border-radius: 4px;
}

.scrollable-table::-webkit-scrollbar-thumb:hover {
    background: #e74c3c;
}
</style>
@endpush

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Bajnokok Csarnoka</h1>
            <p class="text-muted">Pilóták és versenyek történelmi adatai szűréssel</p>
        </div>

        <!-- Pilots Section -->
        <div class="card-f1 mb-5">
            <h2 class="text-f1 mb-4"><strong>Pilóták</strong></h2>
            
            <!-- Pilots Filter Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('database.index') }}" class="d-flex gap-2">
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Keresés név alapján...">
                        <select class="form-select" name="nationality">
                            <option value="">Minden nemzetiség</option>
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality }}" 
                                        {{ request('nationality') == $nationality ? 'selected' : '' }}>
                                    {{ $nationality }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-f1">Szűrés</button>
                        @if(request('search') || request('nationality'))
                            <a href="{{ route('database.index') }}" class="btn btn-outline-secondary">Törlés</a>
                        @endif
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-f1 fs-6">{{ $pilots->count() }} pilóta</span>
                </div>
            </div>

            @if($pilots->count() > 0)
                <div class="scrollable-table">
                    <table class="table table-f1 mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th>ID</th>
                                <th>Név</th>
                                <th>Nem</th>
                                <th>Születési dátum</th>
                                <th>Nemzetiség</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $pilot->az }}</span></td>
                                <td class="fw-bold">{{ $pilot->name }}</td>
                                <td>
                                    @if($pilot->gender == 'F')
                                        <span class="badge bg-primary">Férfi</span>
                                    @elseif($pilot->gender == 'N')
                                        <span class="badge bg-warning">Nő</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $pilot->birth_date ? $pilot->birth_date->format('Y.m.d') : '-' }}</td>
                                <td>{{ $pilot->nationality ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-3">
                    <p>Nincsenek pilóták a megadott feltételekkel.</p>
                </div>
            @endif
        </div>

        <!-- Grand Prix Section -->
        <div class="card-f1 mb-5">
            <h2 class="text-f1 mb-4"><strong>Nagydíjak</strong></h2>
            
            <!-- Grand Prix Filter Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('database.index') }}" class="d-flex gap-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="nationality" value="{{ request('nationality') }}">
                        <select class="form-select" name="year">
                            <option value="">Minden év</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" 
                                        {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" 
                               class="form-control" 
                               name="location" 
                               value="{{ request('location') }}" 
                               placeholder="Keresés helyszín alapján...">
                        <button type="submit" class="btn btn-f1">Szűrés</button>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-f1 fs-6">{{ $grandPrix->count() }} verseny</span>
                </div>
            </div>

            @if($grandPrix->count() > 0)
                <div class="scrollable-table">
                    <table class="table table-f1 mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th>ID</th>
                                <th>Dátum</th>
                                <th>Verseny neve</th>
                                <th>Helyszín</th>
                                <th>Év</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grandPrix as $gp)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $gp->id }}</span></td>
                                <td>{{ $gp->race_date->format('Y.m.d') }}</td>
                                <td class="fw-bold">{{ $gp->name }}</td>
                                <td>{{ $gp->location }}</td>
                                <td><span class="badge bg-info">{{ $gp->race_date->format('Y') }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-3">
                    <p>Nincsenek versenyek a megadott feltételekkel.</p>
                </div>
            @endif
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
