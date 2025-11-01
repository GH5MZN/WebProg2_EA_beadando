@extends('layouts.app-layout')

@section('title', 'Pilóta Szerkesztése - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">✏️ Pilóta Szerkesztése</h1>
            <p class="lead">{{ $pilot->name }} adatainak módosítása</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-f1">
                    <h2 class="text-f1 mb-4 text-center">📝 Pilóta Adatok Módosítása</h2>
                    
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
                                       style="background-color: #f8f9fa;">
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

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Nem *</label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender" 
                                        required>
                                    <option value="">Válassz...</option>
                                    <option value="Male" {{ old('gender', $pilot->gender) == 'Male' ? 'selected' : '' }}>👨 Férfi</option>
                                    <option value="Female" {{ old('gender', $pilot->gender) == 'Female' ? 'selected' : '' }}>👩 Nő</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Birth Date -->
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Születési Dátum *</label>
                                <input type="date" 
                                       class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date', $pilot->birth_date->format('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nationality -->
                            <div class="col-md-6 mb-4">
                                <label for="nationality" class="form-label">Nemzetiség *</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" 
                                        id="nationality" 
                                        name="nationality" 
                                        required>
                                    <option value="">Válassz nemzetiséget...</option>
                                    <option value="British" {{ old('nationality', $pilot->nationality) == 'British' ? 'selected' : '' }}>🇬🇧 Brit</option>
                                    <option value="German" {{ old('nationality', $pilot->nationality) == 'German' ? 'selected' : '' }}>🇩🇪 Német</option>
                                    <option value="Dutch" {{ old('nationality', $pilot->nationality) == 'Dutch' ? 'selected' : '' }}>🇳🇱 Holland</option>
                                    <option value="Spanish" {{ old('nationality', $pilot->nationality) == 'Spanish' ? 'selected' : '' }}>🇪🇸 Spanyol</option>
                                    <option value="French" {{ old('nationality', $pilot->nationality) == 'French' ? 'selected' : '' }}>🇫🇷 Francia</option>
                                    <option value="Italian" {{ old('nationality', $pilot->nationality) == 'Italian' ? 'selected' : '' }}>🇮🇹 Olasz</option>
                                    <option value="Brazilian" {{ old('nationality', $pilot->nationality) == 'Brazilian' ? 'selected' : '' }}>🇧🇷 Brazil</option>
                                    <option value="Mexican" {{ old('nationality', $pilot->nationality) == 'Mexican' ? 'selected' : '' }}>🇲🇽 Mexikói</option>
                                    <option value="Canadian" {{ old('nationality', $pilot->nationality) == 'Canadian' ? 'selected' : '' }}>🇨🇦 Kanadai</option>
                                    <option value="Australian" {{ old('nationality', $pilot->nationality) == 'Australian' ? 'selected' : '' }}>🇦🇺 Ausztrál</option>
                                    <option value="Finnish" {{ old('nationality', $pilot->nationality) == 'Finnish' ? 'selected' : '' }}>🇫🇮 Finn</option>
                                    <option value="Japanese" {{ old('nationality', $pilot->nationality) == 'Japanese' ? 'selected' : '' }}>🇯🇵 Japán</option>
                                    <option value="Hungarian" {{ old('nationality', $pilot->nationality) == 'Hungarian' ? 'selected' : '' }}>🇭🇺 Magyar</option>
                                    <!-- If the current nationality is not in the list, add it -->
                                    @if(!in_array($pilot->nationality, ['British', 'German', 'Dutch', 'Spanish', 'French', 'Italian', 'Brazilian', 'Mexican', 'Canadian', 'Australian', 'Finnish', 'Japanese', 'Hungarian']))
                                        <option value="{{ $pilot->nationality }}" selected>🏳️ {{ $pilot->nationality }}</option>
                                    @endif
                                    <option value="Other" {{ old('nationality', $pilot->nationality) == 'Other' ? 'selected' : '' }}>🏳️ Egyéb</option>
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