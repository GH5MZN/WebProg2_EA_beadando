@props(['title', 'icon'])

<h2 class="text-center mb-4">
    <i class="fas fa-shield-alt"></i> Admin Felület
</h2>

<div class="admin-nav mb-4">
    <div class="btn-group w-100" role="group">
        <a href="{{ route('admin.contact-messages') }}" 
           class="add-pilot-button {{ request()->routeIs('admin.contact-messages') ? '' : 'btn-outline' }}">
            <i class="fas fa-envelope"></i> Kontakt Üzenetek
        </a>
        <a href="{{ route('admin.users') }}" 
           class="add-pilot-button {{ request()->routeIs('admin.users') ? '' : 'btn-outline' }}">
            <i class="fas fa-users"></i> Felhasználók
        </a>
    </div>
</div>

<h3 class="mb-4">
    <i class="fas {{ $icon }}"></i> {{ $title }}
</h3>

@if(session('success'))
    <div class="alert alert-success" role="alert">
        <strong>Siker!</strong> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        <strong>Hiba!</strong> {{ session('error') }}
    </div>
@endif
