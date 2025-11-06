<!DOCTYPE HTML>
<html>
	<head>
		<title>@yield('title', 'F1 Tech Solutions')</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{ asset('landed/assets/css/main.css') }}" />
		<noscript><link rel="stylesheet" href="{{ asset('landed/assets/css/noscript.css') }}" /></noscript>
		<link rel="stylesheet" href="{{ asset('landed/assets/css/fontawesome-all.min.css') }}" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ asset('css/f1-styles.css') }}" rel="stylesheet">
		@stack('styles')
	</head>
	<body class="is-preload">

		<!-- Header -->
		<header id="header">
			<div class="container">
				<div class="logo">
					@guest
						<form method="POST" action="{{ route('login') }}" class="header-login-form" id="headerLoginForm">
							@csrf
							<input type="email" name="email" placeholder="Email" required class="header-input">
							<input type="password" name="password" placeholder="Jelszó" required class="header-input">
							<button type="submit" class="header-button">Belépés</button>
						</form>
						@if(session('login_error'))
							<script>
								document.addEventListener('DOMContentLoaded', function() {
									alert('{{ session('login_error') }}');
								});
							</script>
						@endif
					@else
						<div class="user-info-display">
							Üdv, {{ Auth::user()->name }}! 
							<form method="POST" action="{{ route('logout') }}" class="logout-form-inline">
								@csrf
								<button type="submit" class="logout-button">(Kilépés)</button>
							</form>
						</div>
					@endguest
				</div>
				<nav>
					<ul>
						<li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Főoldal</a></li>
						<li><a href="{{ route('pilots.index') }}" class="{{ request()->routeIs('pilots.*') || request()->routeIs('history') ? 'active' : '' }}">Jelenlegi pilóták (CRUD)</a></li>
						<li><a href="{{ route('diagrams') }}" class="{{ request()->routeIs('diagrams') ? 'active' : '' }}">Diagramok</a></li>
						<li><a href="{{ route('database.index') }}" class="{{ request()->routeIs('database.index') ? 'active' : '' }}">Adatbázis menü</a></li>
						<li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kapcsolat</a></li>
						@auth
							@if(auth()->user()->is_admin)
								<li><a href="{{ route('admin.contact-messages') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">🛡️ Admin</a></li>
							@endif
						@endauth
					</ul>
				</nav>
			</div>
		</header>

		<!-- Main Content -->
		<main id="main">
			@yield('content')
		</main>

		<!-- Footer -->
		<footer id="footer">
			<div class="footer-container">
				<p>&copy; 2025 F1 Akadémia. All rights reserved.</p>
				<p><small>Készítette: Marton Zsolt (CP7RLL) és Jagicza Bence (GH5MZN)</small></p>
				<p><small>Powered by Laravel & Landed Theme</small></p>
			</div>
		</footer>

		<!-- Scripts -->
		<script src="{{ asset('landed/assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/jquery.scrolly.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/jquery.dropotron.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/jquery.scrollex.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/browser.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/breakpoints.min.js') }}"></script>
		<script src="{{ asset('landed/assets/js/util.js') }}"></script>
		<script src="{{ asset('landed/assets/js/main.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		@stack('scripts')



		<script>
			// AJAX bejelentkezési űrlap kezelése
			document.addEventListener('DOMContentLoaded', function() {
				const loginForm = document.getElementById('headerLoginForm');
				if (loginForm) {
					loginForm.addEventListener('submit', function(e) {
						e.preventDefault();
						
						const formData = new FormData(this);
						const submitButton = this.querySelector('button[type="submit"]');
						const originalText = submitButton.textContent;
						
						submitButton.textContent = 'Belépés...';
						submitButton.disabled = true;
						
						fetch(this.action, {
							method: 'POST',
							body: formData,
							headers: {
								'X-Requested-With': 'XMLHttpRequest',
								'Accept': 'application/json'
							}
						})
						.then(response => {
							if (response.ok) {
								window.location.reload();
							} else {
								return response.json();
							}
						})
						.then(data => {
							if (data && !data.success) {
								alert(data.message || 'Helytelen email cím vagy jelszó!');
							}
						})
						.catch(error => {
							alert('Helytelen email cím vagy jelszó!');
						})
						.finally(() => {
							submitButton.textContent = originalText;
							submitButton.disabled = false;
						});
					});
				}
			});
		</script>

	</body>
</html>
