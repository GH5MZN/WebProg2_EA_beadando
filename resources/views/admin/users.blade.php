@extends('layouts.landed-layout')

@section('title', 'Regisztrált Felhasználók - Admin')

@section('content')
<div class="container" style="padding: 2rem;">
    <div class="row">
        <div class="col-12">
            <div class="contact-form">
                <h2 class="text-center mb-4">
                    <i class="fas fa-shield-alt"></i> Admin Felület
                </h2>
                
                <!-- Admin Navigation -->
                <div class="admin-nav mb-4">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('admin.contact-messages') }}" class="btn btn-outline-primary {{ request()->routeIs('admin.contact-messages') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i> Kontakt Üzenetek
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Felhasználók
                        </a>
                    </div>
                </div>
                
                <h3 class="mb-4">
                    <i class="fas fa-users"></i> Regisztrált Felhasználók
                </h3>
                
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Név</th>
                                    <th>Email</th>
                                    <th>Email Verificálva</th>
                                    <th>Regisztráció Dátuma</th>
                                    <th>Utolsó Módosítás</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Verificálva
                                            </span>
                                            <br><small class="text-muted">{{ $user->email_verified_at->format('Y-m-d H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Nem verificált
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                    
                    <!-- Statisztikák -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $users->total() }}</h3>
                                    <p>Összes felhasználó</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</h3>
                                    <p>Verificált email</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\User::whereDate('created_at', today())->count() }}</h3>
                                    <p>Mai regisztrációk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i>
                        Még nincsenek regisztrált felhasználók.
                    </div>
                @endif
                
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus"></i> Új regisztráció
                    </a>
                    <a href="{{ url('/phpmyadmin') }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-database"></i> phpMyAdmin megnyitása
                    </a>
                    <a href="{{ route('admin.contact-messages') }}" class="btn btn-outline-info">
                        <i class="fas fa-envelope"></i> Kontakt üzenetek
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

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.badge {
    font-size: 0.85em;
}
</style>
@endsection