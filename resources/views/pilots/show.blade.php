@extends('layouts.app-layout')

@section('title', $pilot->name . ' - F1 Pilóta Profil')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Driver Header -->
        <div class="hero-section">
            <h1 class="hero-title">🏎️ {{ $pilot->name }}</h1>
            <p class="lead">Pilóta ID: {{ $pilot->pilot_id }} | {{ $pilot->nationality }}</p>
        </div>

        <!-- Driver Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Nem</h6>
                    <p class="h5 mb-0">
                        @if($pilot->gender == 'Male')
                            <span class="text-primary">👨 Férfi</span>
                        @else
                            <span class="text-danger">👩 Nő</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Születési dátum</h6>
                    <p class="h5 mb-0">{{ $pilot->birth_date->format('Y. m. d.') }}</p>
                    <small class="text-muted">{{ $pilot->birth_date->age }} éves</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Nemzetiség</h6>
                    <p class="h5 mb-0">🏁 {{ $pilot->nationality }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-f1 text-center">
                    <h6 class="text-muted">Verseny eredmények</h6>
                    <p class="h5 mb-0">{{ $pilotResults->total() }} db</p>
                </div>
            </div>
        </div>

        <!-- Race Results -->
        @if($pilotResults->count() > 0)
        <div class="card-f1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-f1 mb-0">🏆 Verseny eredmények</h3>
                <span class="badge bg-f1">{{ $pilotResults->total() }} eredmény</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-f1">
                    <thead>
                        <tr>
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
        @else
        <div class="card-f1 text-center">
            <div style="font-size: 3em; color: #ff6b6b;">🏁</div>
            <h3 class="text-f1">Nincsenek verseny eredmények</h3>
            <p class="text-muted">Ez a pilóta még nem vett részt versenyeken az adatbázisban.</p>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-5">
            <a href="{{ route('pilots.index') }}" class="btn btn-outline-f1">
                ← Vissza a pilótákhoz
            </a>
            <div>
                <a href="{{ route('pilots.edit', $pilot->pilot_id) }}" class="btn btn-outline-warning">
                    ✏️ Pilóta szerkesztése
                </a>
                <button type="button" 
                        class="btn btn-outline-danger" 
                        onclick="confirmDelete('{{ $pilot->pilot_id }}', '{{ $pilot->name }}')">
                    🗑️ Törlés
                </button>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-f1">🏠 Főoldalra</a>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilóta törlése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Biztosan törölni szeretnéd ezt a pilótát?</p>
                <p><strong id="pilotName"></strong></p>
                <p class="text-danger"><small>Ez a művelet nem visszavonható!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Törlés</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(pilotId, pilotName) {
    document.getElementById('pilotName').textContent = pilotName;
    document.getElementById('deleteForm').action = '{{ route("pilots.index") }}/' + pilotId;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection