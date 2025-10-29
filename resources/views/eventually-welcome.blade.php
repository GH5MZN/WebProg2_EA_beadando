@extends('layouts.eventually-layout')

@section('title', 'F1 Championship 2025 - Official Homepage')

@section('content')
		<!-- Navigation -->
		<nav id="nav" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); padding: 1em 0;">
			<div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2em;">
				<div style="color: #ff6b6b; font-weight: bold; font-size: 1.2em;">🏁 F1 2025</div>
				<ul style="display: flex; list-style: none; margin: 0; padding: 0; gap: 2em;">
					<li><a href="{{ route('home') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">Home</a></li>
					<li><a href="{{ route('history') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">F1 History</a></li>
					<li><a href="{{ route('contact') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">Contact</a></li>
					<li class="dropdown" style="position: relative;">
						<a href="#" onclick="toggleDropdown()" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s; cursor: pointer;">Login ▼</a>
						<div id="loginDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: rgba(0,0,0,0.95); border-radius: 5px; padding: 1em; min-width: 200px; margin-top: 0.5em;">
							<a href="{{ route('login') }}" style="display: block; color: white; text-decoration: none; padding: 0.5em 0; border-bottom: 1px solid rgba(255,255,255,0.1);">Sign In</a>
							<a href="{{ route('register') }}" style="display: block; color: white; text-decoration: none; padding: 0.5em 0;">Sign Up</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>

		<!-- Header -->
			<header id="header" style="margin-top: 4em;">
				<h1>F1 Championship 2025</h1>
				<p>Welcome to the official F1 Championship website!<br />
				Explore racing history, track drivers, and stay updated with the latest news.</p>
				
				<!-- Quick Actions -->
				<div style="margin-top: 2em;">
					<a href="{{ route('history') }}" style="display: inline-block; margin: 0 1em; padding: 0.8em 2em; background: #ff6b6b; border-radius: 25px; color: white; text-decoration: none; font-weight: bold; transition: all 0.3s;">Explore F1 History</a>
					<a href="{{ route('contact') }}" style="display: inline-block; margin: 0 1em; padding: 0.8em 2em; background: rgba(255,255,255,0.1); border-radius: 25px; color: inherit; text-decoration: none; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s;">Get in Touch</a>
				</div>
			</header>

		<!-- Newsletter Signup -->
			<form id="signup-form" method="post" action="#" style="margin-top: 3em;">
				@csrf
				<input type="email" name="email" id="email" placeholder="Subscribe to F1 Championship updates" />
				<input type="submit" value="Subscribe to Newsletter" />
			</form>

		<!-- Footer -->
			<footer id="footer">
				<ul class="icons">
					<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
					<li><a href="#" class="icon brands fa-youtube"><span class="label">YouTube</span></a></li>
					<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
				</ul>
				<ul class="copyright">
					<li>&copy; F1 Championship 2025. All rights reserved.</li>
					<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</footer>

		<script>
			function toggleDropdown() {
				const dropdown = document.getElementById('loginDropdown');
				dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
			}

			// Close dropdown when clicking outside
			document.addEventListener('click', function(event) {
				const dropdown = document.getElementById('loginDropdown');
				const loginLink = event.target.closest('.dropdown');
				
				if (!loginLink && dropdown.style.display === 'block') {
					dropdown.style.display = 'none';
				}
			});

			// Add hover effects to navigation
			document.querySelectorAll('#nav a').forEach(link => {
				link.addEventListener('mouseenter', function() {
					this.style.background = 'rgba(255, 107, 107, 0.2)';
				});
				link.addEventListener('mouseleave', function() {
					if (!this.closest('.dropdown')) {
						this.style.background = 'transparent';
					}
				});
			});
		</script>
@endsection