<div class="navigation-menu">
    <div class="navigation-header">
        <div class="navigation-title">
            F1 Tech Solutions - Navigáció
        </div>
    </div>
    
    <div class="menu-grid">
        <a href="{{ route('home') }}" class="menu-card {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="menu-card-content">
                <div class="menu-icon">🏠</div>
                <h3 class="menu-card-title">Főoldal</h3>
                <p class="menu-card-description">Üdvözlő oldal és összefoglaló</p>
            </div>
        </a>
        
        <a href="{{ route('pilots.index') }}" class="menu-card {{ request()->routeIs('pilots.*') ? 'active' : '' }}">
            <div class="menu-card-content">
                <div class="menu-icon">🏎️</div>
                <h3 class="menu-card-title">Jelenlegi pilóták (CRUD)</h3>
                <p class="menu-card-description">2025-ös F1 pilóták kezelése</p>
            </div>
        </a>
        
        <a href="{{ route('diagrams') }}" class="menu-card {{ request()->routeIs('diagrams') ? 'active' : '' }}">
            <div class="menu-card-content">
                <div class="menu-icon">📊</div>
                <h3 class="menu-card-title">Diagramok</h3>
                <p class="menu-card-description">Statisztikák és grafikonok</p>
            </div>
        </a>
        
        <a href="{{ route('database.index') }}" class="menu-card {{ request()->routeIs('database.index') ? 'active' : '' }}">
            <div class="menu-card-content">
                <div class="menu-icon">🗄️</div>
                <h3 class="menu-card-title">Adatbázis menü</h3>
                <p class="menu-card-description">3 tábla adatainak megjelenítése</p>
            </div>
        </a>
        
        <a href="{{ route('contact') }}" class="menu-card {{ request()->routeIs('contact') ? 'active' : '' }}">
            <div class="menu-card-content">
                <div class="menu-icon">📞</div>
                <h3 class="menu-card-title">Kapcsolat</h3>
                <p class="menu-card-description">Kapcsolatfelvételi űrlap</p>
            </div>
        </a>
    </div>
</div>
