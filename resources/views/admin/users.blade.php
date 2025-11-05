@extends('layouts.landed-layout')

@section('title', 'Regisztrált Felhasználók - Admin')

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
                                    <th>Email Megerősítve</th>
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
                                                <i class="fas fa-check"></i> Megerősítve
                                            </span>
                                            <br><small class="text-muted">{{ $user->email_verified_at->format('Y-m-d H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Nem megerősített
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
                            <div class="card bg-f1-red text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $users->total() }}</h3>
                                    <p>Összes felhasználó</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-dark text-white">
                                <div class="card-body text-center">
                                    <h3>{{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</h3>
                                    <p>Megerősített email</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-silver text-dark">
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
                    <a href="{{ route('register') }}" class="btn btn-f1-red">
                        <i class="fas fa-user-plus"></i> Új regisztráció
                    </a>
                    <a href="{{ route('admin.contact-messages') }}" class="btn btn-f1-dark">
                        <i class="fas fa-envelope"></i> Kontakt üzenetek
                    </a>
                </div>
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

.btn-f1-red {
    background: linear-gradient(135deg, #ff6b6b, #dc3545);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-f1-red:hover {
    background: linear-gradient(135deg, #dc3545, #ff6b6b);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
}

.btn-f1-dark {
    background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-f1-dark:hover {
    background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(44, 44, 44, 0.4);
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

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-size: 0.85em;
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