<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'F1 Tech Solutions')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/f1-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/f1-racing-animation.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Background Video -->
    <div class="video-background" id="videoBackground">
        <!-- YouTube videó iframe (csak user interaction után fog működni) -->
        <iframe 
            id="bgVideo"
            src=""
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            style="display: none;">
        </iframe>
        
        <!-- Alternatív CSS-alapú animált háttér -->
        <div class="css-video-background"></div>
    </div>
    
    <!-- Fallback Animated Background -->
    <div class="animated-background"></div>
    <div class="racing-stripes"></div>
    
    <!-- Enhanced F1 Racing Animation -->
    <div class="f1-cars-animation">
        <div class="f1-car"></div>
        <div class="f1-car"></div>
        <div class="f1-car"></div>
        <div class="f1-car"></div>
    </div>
    <div class="track-lines"></div>
    <div class="racing-lights"></div>
    
    <!-- Video Overlay for better readability -->
    <div class="video-overlay"></div>

    <!-- Video Toggle Button -->
    <button id="videoToggle" class="video-toggle" title="Videó ki/be">
        🎬
    </button>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Főoldal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="comingSoon('Adatbázis')">Adatbázis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kapcsolat</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="comingSoon('Üzenetek')">Üzenetek</a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="comingSoon('Diagram')">Diagram</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pilots.*') ? 'active' : '' }}" href="{{ route('pilots.index') }}">Pilóták(CRUD)</a>
                    </li>
                    @auth
                    @if(auth()->user()->is_admin ?? false)
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="comingSoon('Admin')">Admin</a>
                    </li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Lebegő Login/Register Box -->
    <div class="floating-login">
        @guest
        <h5>🏁 F1 Login</h5>
        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            <input type="email" name="email" class="form-control" placeholder="Email cím" required>
            <input type="password" name="password" class="form-control" placeholder="Jelszó" required>
            <button type="submit" class="btn btn-f1">🏎️ Bejelentkezés</button>
        </form>
        
        <div class="text-center mt-2">
            <small class="text-muted">Nincs még fiókod?</small>
        </div>
        
        <a href="{{ route('register') }}" class="btn btn-outline-f1 btn-sm">
            📝 Regisztráció
        </a>
        
        <div class="text-center mt-2">
            <small><a href="#" class="text-muted" style="text-decoration: none;">Elfelejtett jelszó?</a></small>
        </div>
        @else
        <h5>🏁 Üdv, {{ auth()->user()->name }}!</h5>
        <div class="text-center mb-3">
            <small class="text-muted">Bejelentkezve</small>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-f1">
                🚪 Kijelentkezés
            </button>
        </form>
        
        <div class="text-center mt-2">
            <small><a href="#" class="text-muted" style="text-decoration: none;">Profil beállítások</a></small>
        </div>
        @endguest
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 F1 Tech Solutions. All rights reserved.</p>
            <p>Készítette: Marton Zsolt (C7PRLL) és Jagicza Bence (GH5MZN)</p>
            <p><small>Powered by Laravel & Bootstrap 🏁</small></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function comingSoon(feature) {
            alert('🏁 ' + feature + ' - Coming Soon!\nEz a funkció hamarosan elérhető lesz.');
        }

        // Enhanced Video Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const videoToggle = document.getElementById('videoToggle');
            const videoBackground = document.querySelector('.video-background');
            const bgVideo = document.getElementById('bgVideo');
            let videoVisible = true;
            let userInteracted = false;

            // YouTube videó URL
            const youtubeUrl = "https://www.youtube.com/embed/3BEHQEiDgW0?autoplay=1&mute=1&loop=1&playlist=3BEHQEiDgW0&controls=0&showinfo=0&modestbranding=1&iv_load_policy=3&rel=0&disablekb=1&fs=0&cc_load_policy=0&playsinline=1&enablejsapi=0";

            // Első user interaction után próbálja betölteni a YouTube videót
            function enableYouTubeVideo() {
                if (!userInteracted) {
                    userInteracted = true;
                    bgVideo.src = youtubeUrl;
                    bgVideo.style.display = 'block';
                    // CSS animációt halványítja
                    document.querySelector('.css-video-background').style.opacity = '0.1';
                }
            }

            // User interaction detektálása
            document.addEventListener('click', enableYouTubeVideo, { once: true });
            document.addEventListener('keydown', enableYouTubeVideo, { once: true });
            document.addEventListener('scroll', enableYouTubeVideo, { once: true });

            videoToggle.addEventListener('click', function() {
                if (videoVisible) {
                    videoBackground.classList.add('hidden');
                    videoToggle.textContent = '🎥';
                    videoToggle.classList.add('paused');
                    videoToggle.title = 'Háttér bekapcsolás';
                    videoVisible = false;
                } else {
                    videoBackground.classList.remove('hidden');
                    videoToggle.textContent = '🎬';
                    videoToggle.classList.remove('paused');
                    videoToggle.title = 'Háttér kikapcsolás';
                    videoVisible = true;
                    // YouTube videó indítása ha még nem történt meg
                    enableYouTubeVideo();
                }
            });
        });
    </script>
</body>
</html>