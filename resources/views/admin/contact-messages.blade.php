@extends('layouts.landed-layout')

@section('title', 'Kontakt Üzenetek - Admin')

@section('content')
<div class="container" style="padding: 2rem;">
    <div class="row">
        <div class="col-12">
            <div class="contact-form">
                <h2 class="text-center mb-4">
                    <i class="fas fa-envelope"></i> Kontakt Üzenetek
                </h2>
                
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
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $messages->total() }}</h3>
                                    <p>Összes üzenet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\ContactMessage::where('is_read', true)->count() }}</h3>
                                    <p>Olvasott üzenetek</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
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
                
                <div class="text-center mt-4">
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Vissza a kapcsolat oldalra
                    </a>
                    <a href="{{ url('/phpmyadmin') }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-database"></i> phpMyAdmin megnyitása
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.table th {
    background: #343a40 !important;
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
}
</style>
@endsection