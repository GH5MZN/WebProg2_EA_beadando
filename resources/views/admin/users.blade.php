@extends('layouts.landed-layout')

@section('title', 'Regisztrált Felhasználók - Admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="contact-form">
                <x-admin-header title="Regisztrált Felhasználók" icon="fa-users" />
                
                @if($users->count() > 0)
                    <div class="card-f1">
                        <div class="table-responsive">
                            <table class="table table-f1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Név</th>
                                        <th>Email</th>
                                        <th class="medium-screen-only">Email Megerősítve</th>
                                        <th class="large-screen-only">Regisztráció Dátuma</th>
                                        <th class="large-screen-only">Utolsó Módosítás</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td><span class="pilot-id-badge">{{ $user->id }}</span></td>
                                        <td class="pilot-name-cell">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="medium-screen-only">
                                            @if($user->email_verified_at)
                                                <span class="team-badge bg-success">
                                                    <i class="fas fa-check"></i> Megerősítve
                                                </span>
                                                <br><small class="text-muted">{{ $user->email_verified_at->format('Y-m-d H:i') }}</small>
                                            @else
                                                <span class="team-badge bg-warning">
                                                    <i class="fas fa-clock"></i> Nem megerősített
                                                </span>
                                            @endif
                                        </td>
                                        <td class="large-screen-only">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="large-screen-only">{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                    
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
                                    <h3>{{ $users->where('email_verified_at', '!=', null)->count() }}</h3>
                                    <p>Megerősített email</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-silver text-dark">
                                <div class="card-body text-center">
                                    <h3>{{ $users->where('created_at', '>=', today())->count() }}</h3>
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
            </div>
        </div>
    </div>
</div>
@endsection