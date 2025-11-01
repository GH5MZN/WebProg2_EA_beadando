@extends('layouts.app-layout')

@section('title', 'Pilóták Kezelése - F1 Tech Solutions')

@section('content')
<div class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="hero-section">
            <h1 class="hero-title">🏎️ Pilóták Kezelése (CRUD)</h1>
            <p class="lead">F1 pilóták adatainak teljes körű kezelése<br />
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
                    ➕ Új Pilóta Hozzáadása
                </a>
            </div>
            <div class="col-md-6 text-end">
                <div class="badge bg-f1 fs-6">
                    Összesen: {{ $pilots->total() }} pilóta
                </div>
            </div>
        </div>

        <!-- Pilots Table -->
        <div class="card-f1">
            <h2 class="text-f1 mb-4 text-center">� F1 Pilóták Adatbázis</h2>
            
            @if($pilots->count() > 0)
                <div class="table-responsive">
                    <table class="table table-f1">
                        <thead>
                            <tr>
                                <th>Pilóta ID</th>
                                <th>Pilóta neve</th>
                                <th>Nem</th>
                                <th>Születési dátum</th>
                                <th>Nemzetiség</th>
                                <th width="200">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $pilot->pilot_id }}</span></td>
                                <td class="fw-bold">{{ $pilot->name }}</td>
                                <td>
                                    @if($pilot->gender == 'Male')
                                        <span class="text-primary">👨 Férfi</span>
                                    @else
                                        <span class="text-danger">👩 Nő</span>
                                    @endif
                                </td>
                                <td>{{ $pilot->birth_date->format('Y.m.d') }}</td>
                                <td>� {{ $pilot->nationality }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('pilots.show', $pilot->pilot_id) }}" 
                                           class="btn btn-outline-info" title="Megtekintés">
                                            👁️
                                        </a>
                                        <a href="{{ route('pilots.edit', $pilot->pilot_id) }}" 
                                           class="btn btn-outline-warning" title="Szerkesztés">
                                            ✏️
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Törlés"
                                                onclick="confirmDelete('{{ $pilot->pilot_id }}', '{{ $pilot->name }}')">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $pilots->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 3em; color: #ff6b6b;">�️</div>
                    <h3>Nincsenek pilóták az adatbázisban</h3>
                    <p class="text-muted">Kezdj el új pilóták hozzáadásával!</p>
                    <a href="{{ route('pilots.create') }}" class="btn btn-f1 mt-3">
                        ➕ Első Pilóta Hozzáadása
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