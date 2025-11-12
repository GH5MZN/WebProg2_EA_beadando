@extends('layouts.landed-layout')

@section('title', 'Kontakt Üzenetek - Admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="contact-form">
                <x-admin-header title="Kontakt Üzenetek" icon="fa-envelope" />
                
                @if($messages->count() > 0)
                    <div class="card-f1">
                        <div class="table-responsive">
                            <table class="table table-f1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Név</th>
                                        <th>Email</th>
                                        <th class="large-screen-only">Tárgy</th>
                                        <th class="large-screen-only">Üzenet</th>
                                        <th class="medium-screen-only">Hírlevél</th>
                                        <th class="large-screen-only">IP</th>
                                        <th class="medium-screen-only">Dátum</th>
                                        <th>Műveletek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr class="{{ $message->is_read ? '' : 'unread-message' }}">
                                        <td><span class="pilot-id-badge">{{ $message->id }}</span></td>
                                        <td class="pilot-name-cell">{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td class="large-screen-only">{{ Str::limit($message->subject, 30) }}</td>
                                        <td class="large-screen-only">{{ Str::limit($message->message, 50) }}</td>
                                        <td class="medium-screen-only">
                                            @if($message->newsletter)
                                                <span class="team-badge bg-success">Igen</span>
                                            @else
                                                <span class="team-badge bg-secondary">Nem</span>
                                            @endif
                                        </td>
                                        <td class="large-screen-only">{{ $message->ip_address }}</td>
                                        <td class="medium-screen-only">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="actions-cell">
                                            <div class="action-buttons-container">
                                                @if(!$message->is_read)
                                                    <form action="{{ route('admin.contact-messages.mark-read', $message->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="edit-action-button" title="Olvasottként jelölés">
                                                            <span class="desktop-only">Olvasva</span>
                                                            <span class="mobile-only">O</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="team-badge bg-success">✓ Olvasva</span>
                                                @endif
                                                <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" 
                                                      style="display: inline;" onsubmit="return confirm('Biztosan törölni szeretnéd ezt az üzenetet?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-action-button" title="Törlés">
                                                        <span class="desktop-only">Törlés</span>
                                                        <span class="mobile-only">T</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $messages->links() }}
                    </div>
                    
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
                                    <h3>{{ $messages->where('is_read', true)->count() }}</h3>
                                    <p>Olvasott üzenetek</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-f1-silver text-dark">
                                <div class="card-body text-center">
                                    <h3>{{ $messages->where('is_read', false)->count() }}</h3>
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
@endsection