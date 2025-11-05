@extends('layouts.landed-layout')

@section('title', 'Kontakt Üzenetek - Admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="contact-form">
                <h2 class="text-center mb-4">
                    <i class="fas fa-shield-alt"></i> Admin Felület
                </h2>
                
                <!-- Admin Navigation -->
                <div class="admin-nav mb-4">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('admin.contact-messages') }}" class="btn btn-primary {{ request()->routeIs('admin.contact-messages') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i> Kontakt Üzenetek
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Felhasználók
                        </a>
                    </div>
                </div>
                
                <h3 class="mb-4">
                    <i class="fas fa-envelope"></i> Kontakt Üzenetek
                </h3>
                
                @if($messages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Név</th>
                                    <th>Email</th>
                                    <th>Tárgy</th>
                                    <th>Üzenet</th>
                                    <th>Hírlevél</th>
                                    <th>IP</th>
                                    <th>Dátum</th>
                                    <th>Olvasva</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $message)
                                <tr class="{{ $message->is_read ? '' : 'table-warning' }}">
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ Str::limit($message->subject, 30) }}</td>
                                    <td>{{ Str::limit($message->message, 50) }}</td>
                                    <td>
                                        @if($message->newsletter)
                                            <span class="badge bg-success">Igen</span>
                                        @else
                                            <span class="badge bg-secondary">Nem</span>
                                        @endif
                                    </td>
                                    <td>{{ $message->ip_address }}</td>
                                    <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($message->is_read)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Olvasva
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Új
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $messages->links() }}
                    </div>
                    
                    <!-- Statisztikák -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-f1-red text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $messages->total() }}</h3>
                                    <p>Összes üzenet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-dark text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\ContactMessage::where('is_read', true)->count() }}</h3>
                                    <p>Olvasott üzenetek</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-silver text-dark">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\ContactMessage::where('is_read', false)->count() }}</h3>
                                    <p>Új üzenetek</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i>
                        Még nincsenek kontakt üzenetek.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* F1 színek */
.bg-f1-red {
    background: linear-gradient(135deg, #ff6b6b, #dc3545) !important;
}

.bg-f1-dark {
    background: linear-gradient(135deg, #2c2c2c, #1a1a1a) !important;
}

.bg-f1-silver {
    background: linear-gradient(135deg, #e0e0e0, #c0c0c0) !important;
}

.table {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.table th {
    background: linear-gradient(135deg, #2c2c2c, #1a1a1a) !important;
    color: white !important;
    border: none !important;
}

.table td {
    border-color: rgba(0, 0, 0, 0.1) !important;
    vertical-align: middle;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.admin-nav .btn {
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.admin-nav .btn-primary {
    background: linear-gradient(135deg, #ff6b6b, #dc3545);
    border: none;
}

.admin-nav .btn-outline-primary {
    color: #ff6b6b;
    border-color: #ff6b6b;
}

.admin-nav .btn-outline-primary:hover {
    background: linear-gradient(135deg, #ff6b6b, #dc3545);
    border-color: #ff6b6b;
    color: white;
}
</style>
@endsection