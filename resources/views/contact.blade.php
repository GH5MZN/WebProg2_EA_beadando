@extends('layouts.landed-layout')

@section('title', 'Kapcsolat - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Kapcsolat</h1>
            <p class="lead">Vedd fel velünk a kapcsolatot bármilyen kérdéssel, visszajelzéssel vagy megkereséssel.</p>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-f1">
                    @if(session('success'))
                        <div class="alert alert-success alert-f1 mb-4">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->has('system'))
                        <div class="alert alert-danger alert-f1 mb-4">
                            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first('system') }}
                        </div>
                    @endif
                    
                    <form method="post" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Név *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}"
                                       required 
                                       maxlength="100"
                                       placeholder="Teljes neved">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       required 
                                       maxlength="150"
                                       placeholder="email@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Tárgy *</label>
                            <select name="subject" 
                                    id="subject" 
                                    class="form-control @error('subject') is-invalid @enderror" 
                                    required>
                                <option value="">Válassz egy tárgyat</option>
                                <option value="Általános megkeresés" {{ old('subject') == 'Általános megkeresés' ? 'selected' : '' }}>Általános megkeresés</option>
                                <option value="Technikai támogatás" {{ old('subject') == 'Technikai támogatás' ? 'selected' : '' }}>Technikai támogatás</option>
                                <option value="Partnerség lehetőség" {{ old('subject') == 'Partnerség lehetőség' ? 'selected' : '' }}>Partnerség lehetőség</option>
                                <option value="Média megkeresés" {{ old('subject') == 'Média megkeresés' ? 'selected' : '' }}>Média megkeresés</option>
                                <option value="Visszajelzés és javaslatok" {{ old('subject') == 'Visszajelzés és javaslatok' ? 'selected' : '' }}>Visszajelzés és javaslatok</option>
                                <option value="Egyéb" {{ old('subject') == 'Egyéb' ? 'selected' : '' }}>Egyéb</option>
                            </select>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Üzenet *</label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="6" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      required 
                                      maxlength="2000"
                                      placeholder="Írd le, hogyan segíthetünk...">{{ old('message') }}</textarea>
                            <div class="form-text">
                                <span id="messageCounter">0</span>/2000 karakter
                            </div>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" 
                                       id="newsletter" 
                                       name="newsletter" 
                                       class="form-check-input"
                                       value="1"
                                       {{ old('newsletter') ? 'checked' : '' }}>
                                <label for="newsletter" class="form-check-label">
                                    Szeretnék F1 Tech Solutions frissítéseket és hírlevelet kapni 🏁
                                </label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-f1" id="submitBtn">
                                <i class="fas fa-paper-plane"></i> Üzenet küldése 🏁
                            </button>
                            <div class="mt-2">
                                <small class="text-muted">* Kötelező mezők</small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2em; margin-bottom: 0.5em;">📧</div>
                    <h3 class="text-f1">Email</h3>
                    <p>info@f1techsolutions.com</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2em; margin-bottom: 0.5em;">📱</div>
                    <h3 class="text-f1">Telefon</h3>
                    <p>+36 (1) F1-TECH</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <div style="font-size: 2em; margin-bottom: 0.5em;">📍</div>
                    <h3 class="text-f1">Cím</h3>
                    <p>Budapest Racing HQ<br>Magyarország</p>
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

<!-- Optimalizált contact form script -->
<script src="{{ asset('js/contact-performance.js') }}" defer></script>
@endsection
