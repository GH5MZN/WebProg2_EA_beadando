@extends('layouts.landed-layout')

@section('title', $pilot->name . ' - F1 Pilóta Profil')

@push('styles')
<!-- CSS már az f1-styles.css-ben van -->
@endpush

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Driver Header -->
        <div class="hero-section">
            <h1 class="hero-title"><strong>{{ $pilot->name }}</strong></h1>
        </div>

        <!-- Driver Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Csapat</h4>
                    <p class="h3 mb-0 text-f1">
                        @if($pilot->team)
                            <strong>{{ $pilot->team }}</strong>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Nemzetiség</h4>
                    <p class="h3 mb-0 text-f1">
                        @if($pilot->nationality)
                            <strong>{{ $pilot->nationality }}</strong>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-f1 text-center">
                    <h4 class="text-f1">Pilóta ID</h4>
                    <p class="h3 mb-0">
                        <span class="badge bg-f1 fs-5">{{ $pilot->pilot_id }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Results -->
        @if($pilotResults->count() > 0)
        <div class="card-f1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-f1 mb-0">Eredmények</h3>
                <span class="badge bg-f1">{{ $pilotResults->total() }} eredmény</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-f1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Dátum</th>
                            <th>Grand Prix</th>
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
                            <td><span class="badge bg-secondary">{{ $result->id }}</span></td>
                            <td>{{ $result->race_date->format('Y.m.d') }}</td>
                            <td>
                                @if($result->grandPrix)
                                    <strong>{{ $result->grandPrix->name }}</strong><br>
                                    <small class="text-muted">{{ $result->grandPrix->location }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($result->position)
                                    @php
                                        $badgeClass = 'bg-secondary';
                                        if($result->position <= 3) $badgeClass = 'bg-success';
                                        elseif($result->position <= 10) $badgeClass = 'bg-warning text-dark';
                                        else $badgeClass = 'bg-f1';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        P{{ $result->position }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">DNF</span>
                                @endif
                            </td>
                            <td>{{ $result->issue ?: '-' }}</td>
                            <td>{{ $result->team }}</td>
                            <td>{{ $result->car_type }}</td>
                            <td>{{ $result->engine }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination for results -->
            @if($pilotResults->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pilotResults->links() }}
                </div>
            @endif
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-5">
            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                ← Vissza a pilótákhoz
            </a>
            <div>
                <a href="{{ route('pilots.edit', $pilot->pilot_id) }}" class="btn btn-outline-warning">
                    Pilóta szerkesztése
                </a>
                <button type="button" 
                        class="btn btn-outline-danger" 
                        onclick="deleteDirectly('{{ $pilot->pilot_id }}', '{{ $pilot->name }}')">
                    Törlés
                </button>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-f1">🏠 Főoldalra</a>
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
