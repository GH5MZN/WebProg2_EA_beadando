@extends('layouts.app-layout')

@section('title', 'Új Pilóta Hozzáadása - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">🏎️ Új Pilóta Hozzáadása</h1>
            <p class="lead">Add hozzá új pilótát az F1 adatbázishoz</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-f1">
                    <h2 class="text-f1 mb-4 text-center">📝 Pilóta Adatok</h2>
                    
                    <form action="{{ route('pilots.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Pilot ID -->
                            <div class="col-md-6 mb-3">
                                <label for="pilot_id" class="form-label">Pilóta ID *</label>
                                <input type="text" 
                                       class="form-control @error('pilot_id') is-invalid @enderror" 
                                       id="pilot_id" 
                                       name="pilot_id" 
                                       value="{{ old('pilot_id') }}"
                                       placeholder="pl. HAM001"
                                       maxlength="10"
                                       required>
                                @error('pilot_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Egyedi azonosító, max 10 karakter</div>
                            </div>

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
                        </div>

                        <div class="row">
                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Nem *</label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender" 
                                        required>
                                    <option value="">Válassz...</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>👨 Férfi</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>👩 Nő</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Születési Dátum *</label>
                                <input type="date" 
                                       class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" 
                                       name="birth_date" 
                                       value="{{ old('birth_date') }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nationality -->
                            <div class="col-12 mb-4">
                                <label for="nationality" class="form-label">Nemzetiség *</label>
                                <select class="form-select @error('nationality') is-invalid @enderror" 
                                        id="nationality" 
                                        name="nationality" 
                                        required>
                                    <option value="">Válassz nemzetiséget...</option>
                                    <option value="British" {{ old('nationality') == 'British' ? 'selected' : '' }}>🇬🇧 Brit</option>
                                    <option value="German" {{ old('nationality') == 'German' ? 'selected' : '' }}>🇩🇪 Német</option>
                                    <option value="Dutch" {{ old('nationality') == 'Dutch' ? 'selected' : '' }}>🇳🇱 Holland</option>
                                    <option value="Spanish" {{ old('nationality') == 'Spanish' ? 'selected' : '' }}>🇪🇸 Spanyol</option>
                                    <option value="French" {{ old('nationality') == 'French' ? 'selected' : '' }}>🇫🇷 Francia</option>
                                    <option value="Italian" {{ old('nationality') == 'Italian' ? 'selected' : '' }}>🇮🇹 Olasz</option>
                                    <option value="Brazilian" {{ old('nationality') == 'Brazilian' ? 'selected' : '' }}>🇧🇷 Brazil</option>
                                    <option value="Mexican" {{ old('nationality') == 'Mexican' ? 'selected' : '' }}>🇲🇽 Mexikói</option>
                                    <option value="Canadian" {{ old('nationality') == 'Canadian' ? 'selected' : '' }}>🇨🇦 Kanadai</option>
                                    <option value="Australian" {{ old('nationality') == 'Australian' ? 'selected' : '' }}>🇦🇺 Ausztrál</option>
                                    <option value="Finnish" {{ old('nationality') == 'Finnish' ? 'selected' : '' }}>🇫🇮 Finn</option>
                                    <option value="Japanese" {{ old('nationality') == 'Japanese' ? 'selected' : '' }}>🇯🇵 Japán</option>
                                    <option value="Hungarian" {{ old('nationality') == 'Hungarian' ? 'selected' : '' }}>🇭🇺 Magyar</option>
                                    <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>🏳️ Egyéb</option>
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
                            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                                ← Mégse
                            </a>
                            <button type="submit" class="btn btn-f1">
                                ✅ Pilóta Hozzáadása
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