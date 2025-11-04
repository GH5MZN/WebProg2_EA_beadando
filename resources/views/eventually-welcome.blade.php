@extends('layouts.landed-layout')

@section('title', 'Főoldal')

@push('styles')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@endpush

@section('content')
		<!-- Header -->
		<header class="welcome-header">
			<!-- F1 Logo centered -->
			<div style="text-align: center; margin-bottom: 3em;">
				<img src="{{ asset('images/359-3592497_file-f1-svg-f1-logo-png-transparent-png.png') }}" alt="Formula 1 Logo" style="max-width: 400px; height: auto;">
			</div>
			
			<!-- Content with text left and Verstappen right -->
			<div class="header-content" style="display: flex; align-items: center; gap: 2em; max-width: 1200px; margin: 0 auto;">
				<div class="header-left" style="flex: 1;">
					<p class="welcome-subtitle">
						Légy részese a száguldó cirkusz felejthetetlen világának!<br>
						Ismerkedj meg a Formula 1 kiváló pilótáival, úttörő csapataival és tanulj a legjobbaktól!<br>
						Nincs más dolgod, mind jelentkezni nálunk, és mi segítünk megvalósítani álmaidat!<br>
					<br><br>
					A hősöd Ayrton Senna, Michael Schumacher vagy Max Verstappen?<br>
					Tanulj róluk nálunk, légy te is a következő bajnok!
					Ehhez nincs más dolgod, mint regisztrálni <a href="{{ route('register') }}" style="color: #ff6b6b; font-weight: bold; text-decoration: underline;">ITT</a> és beiratkozni tanfolyamaink egyikére!
					<br><br>
					
					</p>
				</div>
				<div class="header-right" style="flex: 1; text-align: right;">
					<img src="https://media.formula1.com/image/upload/c_lfill,w_3392/q_auto/v1740000000/content/dam/fom-website/manual/Misc/Verstappenbacktobacktitles/verstappen-hero.webp" alt="Max Verstappen" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
				</div>
			</div>
		</header>

		<!-- Features Section -->
		<section class="welcome-features">
			<div class="features-grid">
				
				<div class="feature-card">
					<h3 class="feature-title">Pilóták adatbázisa</h3>
					<p class="feature-description">Tekintse meg a Formula 1 pilóták részletes adatait és eredményeit.</p>
					<a href="{{ route('pilots.index') }}" class="feature-link">Böngészés →</a>
				</div>

				<div class="feature-card">
					<h3 class="feature-title">Diagramok</h3>
					<p class="feature-description">Interaktív grafikonok és statisztikák a F1 eredményekről.</p>
					<a href="{{ route('diagrams') }}" class="feature-link">Megtekintés →</a>
				</div>

				<div class="feature-card">
					<h3 class="feature-title">CRUD műveletek</h3>
					<p class="feature-description">Adatok kezelése, szerkesztése és új bejegyzések létrehozása.</p>
					<a href="{{ route('pilots.index') }}" class="feature-link">Kezelés →</a>
				</div>

			</div>
		</section>

@endsection
