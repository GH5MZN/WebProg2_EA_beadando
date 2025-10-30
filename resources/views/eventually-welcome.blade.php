@extends('layouts.eventually-layout')

@section('title', 'F1 Tech Solutions - Formula 1 Inspired Development')

@section('content')
		<!-- Navigation -->
		<nav id="nav" style="background: rgba(0,0,0,0.9); padding: 0.8em 0; margin-bottom: 2em;">
			<div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 1em;">
				<div style="color: #ff6b6b; font-weight: bold; font-size: 1em;">
					🏁 F1
				</div>
				<ul style="display: flex; list-style: none; margin: 0; padding: 0; gap: 0.3em;">
					<li><a href="{{ route('home') }}" class="nav-link active">Főoldal</a></li>
					<li><a href="#" class="nav-link">DB</a></li>
					<li><a href="{{ route('contact') }}" class="nav-link">Kapcsolat</a></li>
					<li><a href="#" class="nav-link">Üzenetek</a></li>
					<li><a href="#" class="nav-link">Chart</a></li>
					<li><a href="#" class="nav-link">CRUD</a></li>
					<li><a href="#" class="nav-link">Admin</a></li>
				</ul>
			</div>
		</nav>

		<!-- Header -->
		<header id="header" style="text-align: center; padding: 3em 2em; max-width: 1000px; margin: 0 auto;">
			<h1 style="font-size: 3em; margin-bottom: 1em; color: #ff6b6b;">🏁 F1 Tech Solutions</h1>
			<p style="font-size: 1.2em; color: rgba(255,255,255,0.8); margin-bottom: 2em;">
				Formula 1 inspired web development with precision and speed
			</p>
			
			<!-- Quick Action Buttons -->
			<div style="margin: 2em 0;">
				<a href="#" style="display: inline-block; margin: 0 1em; padding: 1em 2em; background: #ff6b6b; border-radius: 25px; color: white; text-decoration: none; font-weight: bold;">
					🏎️ Start Project
				</a>
				<a href="{{ route('contact') }}" style="display: inline-block; margin: 0 1em; padding: 1em 2em; background: transparent; border: 2px solid #ff6b6b; border-radius: 25px; color: white; text-decoration: none; font-weight: bold;">
					📧 Contact Us
				</a>
			</div>
		</header>

		<!-- Newsletter -->
		<form id="signup-form" method="post" action="#" style="text-align: center; margin: 3em auto; max-width: 500px; padding: 0 2em;">
			@csrf
			<h3 style="color: #ff6b6b; margin-bottom: 1em;">Join the Racing Team!</h3>
			<input type="email" name="email" id="email" placeholder="your@email.com" style="margin-bottom: 1em;" />
			<input type="submit" value="🏁 Join Now" />
		</form>

		<!-- Footer -->
		<footer style="text-align: center; padding: 2em; margin-top: 3em; background: #222; color: #ccc;">
			<p>&copy; 2025 F1 Tech Solutions. All rights reserved.</p>
			<p><small>Design: HTML5 UP</small></p>
		</footer>

		<style>
			.nav-link {
				color: white;
				text-decoration: none;
				padding: 0.4em 0.8em;
				border-radius: 4px;
				transition: all 0.3s;
				font-size: 0.9em;
				display: block;
			}
			
			.nav-link:hover, .nav-link.active {
				background: rgba(255, 107, 107, 0.3);
			}
			
			/* Mobilra */
			@media (max-width: 768px) {
				#nav > div {
					flex-direction: column;
					gap: 0.5em;
				}
				
				#nav ul {
					gap: 0.5em;
					justify-content: center;
				}
			}
		</style>

		<script>
			// Simple navigation handling
			document.querySelectorAll('.nav-link').forEach(link => {
				link.addEventListener('click', function(e) {
					if (!this.href.includes('route')) {
						e.preventDefault();
						// Simple alert for coming soon features
						alert('🏁 ' + this.textContent + ' - Coming Soon!\nEz a funkció hamarosan elérhető lesz.');
					}
					
					// Update active state
					document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
					this.classList.add('active');
				});
			});
		</script>
@endsection