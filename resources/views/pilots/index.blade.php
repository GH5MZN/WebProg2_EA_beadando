@extends('layouts.landed-layout')

@section('title', 'Pilóták Kezelése - F1 Tech Solutions')

@push('styles')
<link href="{{ asset('css/pilots.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">Jelenlegi Pilóták Kezelése (CRUD)</h1>
            <p class="lead">2025-ös F1 szezon pilótáinak teljes körű kezelése<br />
            Hozzáadás, módosítás, törlés és megtekintés</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Siker!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Hiba!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-md-6">
                <a href="{{ route('pilots.create') }}" class="btn btn-f1">
                    Új Pilóta Hozzáadása
                </a>
            </div>
            <div class="col-md-6 text-end">
                <div class="badge bg-f1 fs-6">
                    Összesen: {{ $pilots->count() }} pilóta
                </div>
            </div>
        </div>

        <!-- Pilots Table -->
        <div class="card-f1">
            <h2 class="text-f1 mb-4 text-center">Az idei pilóták (2025)</h2>
            
            @if($pilots->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th class="d-none d-md-table-cell">ID</th>
                                <th>Név</th>
                                <th class="d-none d-xl-table-cell">Csapat</th>
                                <th class="d-none d-lg-table-cell">Nemzetiség</th>
                                <th>Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                                                        <tr>
                                <td class="d-none d-md-table-cell"><span class="badge bg-secondary">{{ $pilot->pilot_id }}</span></td>
                                <td class="fw-bold">{{ $pilot->name }}</td>
                                <td class="d-none d-xl-table-cell">
                                    @if($pilot->team)
                                        <span class="badge bg-primary">{{ $pilot->team }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell">{{ $pilot->nationality ?? '-' }}</td>
                                <td class="actions-cell">
                                    <div class="d-flex gap-1 w-100">
                                        <a href="{{ route('pilots.show', $pilot->pilot_id) }}" 
                                           class="btn btn-outline-info btn-sm flex-fill" title="Megtekintés">
                                            <span class="d-none d-md-inline">Nézet</span>
                                            <span class="d-md-none">N</span>
                                        </a>
                                        <a href="{{ route('pilots.edit', $pilot->pilot_id) }}" 
                                           class="btn btn-outline-warning btn-sm flex-fill" title="Szerkesztés">
                                            <span class="d-none d-md-inline">Szerk</span>
                                            <span class="d-md-none">S</span>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm flex-fill" 
                                                title="Törlés"
                                                onclick="deleteDirectly('{{ $pilot->pilot_id }}', '{{ $pilot->name }}')">
                                            <span class="d-none d-md-inline">Töröl</span>
                                            <span class="d-md-none">T</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h3>Nincsenek pilóták az adatbázisban</h3>
                    <p class="text-muted">Kezdj el új pilóták hozzáadásával!</p>
                    <a href="{{ route('pilots.create') }}" class="btn btn-f1 mt-3">
                        Első Pilóta Hozzáadása
                    </a>
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



<script>
function deleteDirectly(pilotId, pilotName) {
    if (confirm('Biztosan törölni szeretnéd ezt a pilótát?\n\n' + pilotName + '\n\nEz a művelet nem visszavonható!')) {
        // Create a hidden form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/pilots/' + pilotId;
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        // Add DELETE method
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
