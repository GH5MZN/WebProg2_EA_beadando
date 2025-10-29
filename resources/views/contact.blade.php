@extends('layouts.eventually-layout')

@section('title', 'Contact Us - F1 Championship 2025')

@section('content')
		<!-- Navigation -->
		<nav id="nav" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); padding: 1em 0;">
			<div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2em;">
				<div style="color: #ff6b6b; font-weight: bold; font-size: 1.2em;">🏁 F1 2025</div>
				<ul style="display: flex; list-style: none; margin: 0; padding: 0; gap: 2em;">
					<li><a href="{{ route('home') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">Home</a></li>
					<li><a href="{{ route('history') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">F1 History</a></li>
					<li><a href="{{ route('contact') }}" style="color: #ff6b6b; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; background: rgba(255,107,107,0.2);">Contact</a></li>
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
			<h1>Contact F1 Championship</h1>
			<p>Get in touch with us for any questions, feedback, or inquiries.<br />
			We'd love to hear from you!</p>
		</header>

		<!-- Contact Form -->
		<div style="max-width: 600px; margin: 2em auto; padding: 2em; background: rgba(255,255,255,0.05); border-radius: 15px; backdrop-filter: blur(10px);">
			@if(session('success'))
				<div style="background: rgba(76, 175, 80, 0.2); border: 1px solid #4caf50; color: #4caf50; padding: 1em; border-radius: 8px; margin-bottom: 1.5em; text-align: center;">
					{{ session('success') }}
				</div>
			@endif
			
			<form method="post" action="{{ route('contact.store') }}" style="display: flex; flex-direction: column; gap: 1.5em;" id="contactForm">
				@csrf
				
				<div style="display: flex; gap: 1em;">
					<div style="flex: 1;">
						<label for="name" style="display: block; margin-bottom: 0.5em; color: rgba(255,255,255,0.8);">Name *</label>
						<input type="text" name="name" id="name" required 
							   style="width: 100%; padding: 1em; border: none; border-radius: 8px; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px);"
							   placeholder="Your full name">
					</div>
					<div style="flex: 1;">
						<label for="email" style="display: block; margin-bottom: 0.5em; color: rgba(255,255,255,0.8);">Email *</label>
						<input type="email" name="email" id="email" required 
							   style="width: 100%; padding: 1em; border: none; border-radius: 8px; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px);"
							   placeholder="your.email@example.com">
					</div>
				</div>

				<div>
					<label for="subject" style="display: block; margin-bottom: 0.5em; color: rgba(255,255,255,0.8);">Subject *</label>
					<select name="subject" id="subject" required 
							style="width: 100%; padding: 1em; border: none; border-radius: 8px; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px);">
						<option value="">Select a subject</option>
						<option value="general">General Inquiry</option>
						<option value="technical">Technical Support</option>
						<option value="partnership">Partnership Opportunity</option>
						<option value="media">Media Request</option>
						<option value="feedback">Feedback & Suggestions</option>
						<option value="other">Other</option>
					</select>
				</div>

				<div>
					<label for="message" style="display: block; margin-bottom: 0.5em; color: rgba(255,255,255,0.8);">Message *</label>
					<textarea name="message" id="message" rows="6" required 
							  style="width: 100%; padding: 1em; border: none; border-radius: 8px; background: rgba(255,255,255,0.1); color: white; backdrop-filter: blur(5px); resize: vertical;"
							  placeholder="Tell us how we can help you..."></textarea>
				</div>

				<div style="display: flex; align-items: center; gap: 0.5em;">
					<input type="checkbox" id="newsletter" name="newsletter" style="margin: 0;">
					<label for="newsletter" style="color: rgba(255,255,255,0.8); font-size: 0.9em;">
						I'd like to receive F1 Championship updates and newsletters
					</label>
				</div>

				<button type="submit" 
						style="padding: 1em 2em; background: linear-gradient(135deg, #ff6b6b, #ee5a52); border: none; border-radius: 25px; color: white; font-weight: bold; font-size: 1.1em; cursor: pointer; transition: all 0.3s; align-self: center;">
					Send Message 🏁
				</button>
			</form>
		</div>

		<!-- Contact Info -->
		<div style="display: flex; justify-content: center; gap: 3em; margin: 3em 0; flex-wrap: wrap;">
			<div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 10px; min-width: 200px;">
				<div style="font-size: 2em; margin-bottom: 0.5em;">📧</div>
				<h3 style="margin: 0 0 0.5em 0; color: #ff6b6b;">Email</h3>
				<p style="margin: 0; color: rgba(255,255,255,0.8);">info@f1championship.com</p>
			</div>
			
			<div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 10px; min-width: 200px;">
				<div style="font-size: 2em; margin-bottom: 0.5em;">📱</div>
				<h3 style="margin: 0 0 0.5em 0; color: #ff6b6b;">Phone</h3>
				<p style="margin: 0; color: rgba(255,255,255,0.8);">+1 (555) F1-CHAMP</p>
			</div>
			
			<div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 10px; min-width: 200px;">
				<div style="font-size: 2em; margin-bottom: 0.5em;">📍</div>
				<h3 style="margin: 0 0 0.5em 0; color: #ff6b6b;">Address</h3>
				<p style="margin: 0; color: rgba(255,255,255,0.8);">Monaco Racing HQ<br>Monte Carlo</p>
			</div>
		</div>

		<!-- Back Button -->
		<div style="text-align: center; margin: 2em 0;">
			<a href="{{ route('home') }}" 
			   style="display: inline-block; padding: 0.8em 2em; background: rgba(255,255,255,0.1); border-radius: 25px; color: inherit; text-decoration: none; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s;">
				← Back to Home
			</a>
		</div>

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
					if (!this.style.background.includes('rgba(255,107,107,0.2)')) {
						this.style.background = 'rgba(255, 107, 107, 0.2)';
					}
				});
				link.addEventListener('mouseleave', function() {
					if (!this.closest('.dropdown') && !this.href.includes('contact')) {
						this.style.background = 'transparent';
					}
				});
			});

			// Form submit animation
			document.getElementById('contactForm').addEventListener('submit', function(e) {
				const button = this.querySelector('button[type="submit"]');
				const originalText = button.textContent;
				button.textContent = 'Sending...';
				button.style.background = 'linear-gradient(135deg, #ffa726, #ff9800)';
				button.disabled = true;
			});
		</script>
@endsection