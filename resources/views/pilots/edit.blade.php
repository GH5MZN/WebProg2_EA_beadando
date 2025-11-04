@extends('layouts.landed-layout')

@section('title', 'Pilóta Szerkesztése - F1 Tech Solutions')

@push('styles')
<link href="{{ asset('css/pilots.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Pilóta Szerkesztése</h1>
            <p class="lead">{{ $pilot->name }} adatainak módosítása</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-f1">
                    <h2 class="text-f1 mb-4 text-center">Pilóta Adatok Módosítása</h2>
                    
                    <form action="{{ route('pilots.update', $pilot->pilot_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Pilot ID (readonly) -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="pilot_id_display" class="form-label">Pilóta ID</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="pilot_id_display" 
                                       value="{{ $pilot->pilot_id }}"
                                       readonly
                                       class="readonly-input">
                                <div class="form-text">A Pilóta ID nem módosítható</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Pilóta Neve *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $pilot->name) }}"
                                       placeholder="pl. Lewis Hamilton"
                                       maxlength="255"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Team -->
                            <div class="col-md-6 mb-3">
                                <label for="team" class="form-label">Csapat</label>
                                <select class="form-select @error('team') is-invalid @enderror" 
                                        id="team" 
                                        name="team">
                                    <option value="">Válassz csapatot...</option>
                                    <option value="McLaren" {{ old('team', $pilot->team) == 'McLaren' ? 'selected' : '' }}>McLaren</option>
                                    <option value="Red Bull Racing" {{ old('team', $pilot->team) == 'Red Bull Racing' ? 'selected' : '' }}>Red Bull Racing</option>
                                    <option value="Mercedes" {{ old('team', $pilot->team) == 'Mercedes' ? 'selected' : '' }}>Mercedes</option>
                                    <option value="Ferrari" {{ old('team', $pilot->team) == 'Ferrari' ? 'selected' : '' }}>Ferrari</option>
                                    <option value="Williams" {{ old('team', $pilot->team) == 'Williams' ? 'selected' : '' }}>Williams</option>
                                    <option value="Kick Sauber" {{ old('team', $pilot->team) == 'Kick Sauber' ? 'selected' : '' }}>Kick Sauber</option>
                                    <option value="Racing Bulls" {{ old('team', $pilot->team) == 'Racing Bulls' ? 'selected' : '' }}>Racing Bulls</option>
                                    <option value="Aston Martin" {{ old('team', $pilot->team) == 'Aston Martin' ? 'selected' : '' }}>Aston Martin</option>
                                    <option value="Haas F1 Team" {{ old('team', $pilot->team) == 'Haas F1 Team' ? 'selected' : '' }}>Haas F1 Team</option>
                                    <option value="Alpine" {{ old('team', $pilot->team) == 'Alpine' ? 'selected' : '' }}>Alpine</option>
                                </select>
                                @error('team')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nationality -->
                            <div class="col-md-12 mb-4">
                                <label for="nationality" class="form-label">Nemzetiség</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" 
                                        id="nationality" 
                                        name="nationality">
                                    <option value="">Válassz nemzetiséget...</option>
                                    <option value="argentín" {{ old('nationality', $pilot->nationality) == 'argentín' ? 'selected' : '' }}>argentín</option>
                                    <option value="ausztrál" {{ old('nationality', $pilot->nationality) == 'ausztrál' ? 'selected' : '' }}>ausztrál</option>
                                    <option value="brazil" {{ old('nationality', $pilot->nationality) == 'brazil' ? 'selected' : '' }}>brazil</option>
                                    <option value="brit" {{ old('nationality', $pilot->nationality) == 'brit' ? 'selected' : '' }}>brit</option>
                                    <option value="francia" {{ old('nationality', $pilot->nationality) == 'francia' ? 'selected' : '' }}>francia</option>
                                    <option value="holland" {{ old('nationality', $pilot->nationality) == 'holland' ? 'selected' : '' }}>holland</option>
                                    <option value="japán" {{ old('nationality', $pilot->nationality) == 'japán' ? 'selected' : '' }}>japán</option>
                                    <option value="kanadai" {{ old('nationality', $pilot->nationality) == 'kanadai' ? 'selected' : '' }}>kanadai</option>
                                    <option value="magyar" {{ old('nationality', $pilot->nationality) == 'magyar' ? 'selected' : '' }}>magyar</option>
                                    <option value="monakói" {{ old('nationality', $pilot->nationality) == 'monakói' ? 'selected' : '' }}>monakói</option>
                                    <option value="német" {{ old('nationality', $pilot->nationality) == 'német' ? 'selected' : '' }}>német</option>
                                    <option value="olasz" {{ old('nationality', $pilot->nationality) == 'olasz' ? 'selected' : '' }}>olasz</option>
                                    <option value="spanyol" {{ old('nationality', $pilot->nationality) == 'spanyol' ? 'selected' : '' }}>spanyol</option>
                                    <option value="thai" {{ old('nationality', $pilot->nationality) == 'thai' ? 'selected' : '' }}>thai</option>
                                    <option value="új-zélandi" {{ old('nationality', $pilot->nationality) == 'új-zélandi' ? 'selected' : '' }}>új-zélandi</option>
                                    <option value="egyéb" {{ old('nationality', $pilot->nationality) == 'egyéb' ? 'selected' : '' }}>egyéb</option>
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-3">
                                <small>* kötelező mezők</small>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pilots.show', $pilot->pilot_id) }}" class="btn btn-outline-f1">
                                ← Mégse
                            </a>
                            <button type="submit" class="btn btn-f1">
                                💾 Módosítások Mentése
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back to List -->
        <div class="text-center mt-4">
            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                📋 Vissza a pilóták listájához
            </a>
        </div>
    </div>
</div>
@endsection
