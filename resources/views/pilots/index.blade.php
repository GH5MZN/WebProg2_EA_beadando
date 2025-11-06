@extends('layouts.landed-layout')

@section('title', 'Pilóták Kezelése')

@push('styles')
<link href="{{ asset('css/pilots-index.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="pilots-page-title">Jelenlegi Pilóták (CRUD)</h1>
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
                <a href="{{ route('pilots.create') }}" class="add-pilot-button">
                    Új Pilóta Hozzáadása
                </a>
            </div>
            <div class="col-md-6 text-end">
                <div class="pilot-counter">
                    Összesen: {{ $pilots->total() }} pilóta
                </div>
            </div>
        </div>

        <!-- Pilots Table -->
        <div class="card-f1">
            
            @if($pilots->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th class="mobile-hidden">ID</th>
                                <th>Név</th>
                                <th class="large-screen-only">Csapat</th>
                                <th class="medium-screen-only">Nemzetiség</th>
                                <th>Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                                <tr>
                                    <td class="mobile-hidden"><span class="pilot-id-badge">{{ $pilot->pilot_id }}</span></td>
                                    <td class="pilot-name-cell">{{ $pilot->name }}</td>
                                    <td class="large-screen-only">
                                        @if($pilot->team)
                                            <span class="team-badge">{{ $pilot->team }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="medium-screen-only">{{ $pilot->nationality ?? '-' }}</td>
                                    <td class="actions-cell">
                                        <div class="action-buttons-container">
                                            <a href="{{ route('pilots.show', $pilot->pilot_id) }}" 
                                               class="view-action-button" title="Adatok megtekintése">
                                                <span class="desktop-only">Adatok</span>
                                                <span class="mobile-only">A</span>
                                            </a>
                                            <a href="{{ route('pilots.edit', $pilot->pilot_id) }}" 
                                               class="edit-action-button" title="Szerkesztés">
                                                <span class="desktop-only">Szerk</span>
                                                <span class="mobile-only">S</span>
                                            </a>
                                            <button type="button" 
                                                    class="delete-action-button" 
                                                    title="Törlés"
                                                    onclick="deleteDirectly('{{ $pilot->pilot_id }}', '{{ $pilot->name }}')">
                                                <span class="desktop-only">Töröl</span>
                                                <span class="mobile-only">T</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $pilots->withQueryString()->links() }}
                </div>
            @else
                <div class="empty-state-container">
                    <h3>Nincsenek pilóták az adatbázisban</h3>
                    <p class="empty-state-text">Kezdj el új pilóták hozzáadásával!</p>
                    <a href="{{ route('pilots.create') }}" class="add-pilot-button">
                        Első Pilóta Hozzáadása
                    </a>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="back-to-home-button">
                ← Vissza a főoldalra
            </a>
        </div>
    </div>
</div>



<script>
function deleteDirectly(pilotId, pilotName) {
    if (confirm('Biztosan törölni szeretnéd ezt a pilótát?\n\n' + pilotName + '\n\nEz a művelet nem visszavonható!')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/pilots/' + pilotId;
        form.className = 'hidden-form';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
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
