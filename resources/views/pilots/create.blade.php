@extends('layouts.landed-layout')

@section('title', 'Új Pilóta Hozzáadása - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
                <div class="hero-section">
            <h1 class="hero-title">Új Pilóta Hozzáadása (2025)</h1>
            <p class="lead">Add hozzá új pilótát a 2025-ös F1 szezonhoz</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-f1">
                    <h2 class="text-f1 mb-4 text-center">Pilóta Adatok</h2>
                    
                    <form action="{{ route('pilots.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Pilóta Neve *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
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
                                    <option value="McLaren" {{ old('team') == 'McLaren' ? 'selected' : '' }}>McLaren</option>
                                    <option value="Red Bull Racing" {{ old('team') == 'Red Bull Racing' ? 'selected' : '' }}>Red Bull Racing</option>
                                    <option value="Mercedes" {{ old('team') == 'Mercedes' ? 'selected' : '' }}>Mercedes</option>
                                    <option value="Ferrari" {{ old('team') == 'Ferrari' ? 'selected' : '' }}>Ferrari</option>
                                    <option value="Williams" {{ old('team') == 'Williams' ? 'selected' : '' }}>Williams</option>
                                    <option value="Kick Sauber" {{ old('team') == 'Kick Sauber' ? 'selected' : '' }}>Kick Sauber</option>
                                    <option value="Racing Bulls" {{ old('team') == 'Racing Bulls' ? 'selected' : '' }}>Racing Bulls</option>
                                    <option value="Aston Martin" {{ old('team') == 'Aston Martin' ? 'selected' : '' }}>Aston Martin</option>
                                    <option value="Haas F1 Team" {{ old('team') == 'Haas F1 Team' ? 'selected' : '' }}>Haas F1 Team</option>
                                    <option value="Alpine" {{ old('team') == 'Alpine' ? 'selected' : '' }}>Alpine</option>
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
                                    <option value="argentín" {{ old('nationality') == 'argentín' ? 'selected' : '' }}>argentín</option>
                                    <option value="ausztrál" {{ old('nationality') == 'ausztrál' ? 'selected' : '' }}>ausztrál</option>
                                    <option value="brazil" {{ old('nationality') == 'brazil' ? 'selected' : '' }}>brazil</option>
                                    <option value="brit" {{ old('nationality') == 'brit' ? 'selected' : '' }}>brit</option>
                                    <option value="francia" {{ old('nationality') == 'francia' ? 'selected' : '' }}>francia</option>
                                    <option value="holland" {{ old('nationality') == 'holland' ? 'selected' : '' }}>holland</option>
                                    <option value="japán" {{ old('nationality') == 'japán' ? 'selected' : '' }}>japán</option>
                                    <option value="kanadai" {{ old('nationality') == 'kanadai' ? 'selected' : '' }}>kanadai</option>
                                    <option value="magyar" {{ old('nationality') == 'magyar' ? 'selected' : '' }}>magyar</option>
                                    <option value="monakói" {{ old('nationality') == 'monakói' ? 'selected' : '' }}>monakói</option>
                                    <option value="német" {{ old('nationality') == 'német' ? 'selected' : '' }}>német</option>
                                    <option value="olasz" {{ old('nationality') == 'olasz' ? 'selected' : '' }}>olasz</option>
                                    <option value="spanyol" {{ old('nationality') == 'spanyol' ? 'selected' : '' }}>spanyol</option>
                                    <option value="thai" {{ old('nationality') == 'thai' ? 'selected' : '' }}>thai</option>
                                    <option value="új-zélandi" {{ old('nationality') == 'új-zélandi' ? 'selected' : '' }}>új-zélandi</option>
                                    <option value="egyéb" {{ old('nationality') == 'egyéb' ? 'selected' : '' }}>egyéb</option>
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-3">
                                <small>* csak a név kötelező</small>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                                ← Mégse
                            </a>
                            <button type="submit" class="btn btn-f1">
                                Pilóta Hozzáadása
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back to List -->
        <div class="text-center mt-4">
            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                Vissza a pilóták listájához
            </a>
        </div>
    </div>
</div>
@endsection
