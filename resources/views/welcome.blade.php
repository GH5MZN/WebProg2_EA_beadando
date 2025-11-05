@extends('layouts.landed-layout')

@section('title', 'Főoldal')

@push('styles')
<!-- CSS már az f1-styles.css-ben van -->
@endpush

@section('content')
		<!-- Header -->
		<header class="welcome-header">
			<!-- F1 Logo centered -->
			<div class="welcome-logo-container">
				<img src="{{ asset('images/359-3592497_file-f1-svg-f1-logo-png-transparent-png.png') }}" alt="Formula 1 Logo" class="welcome-logo">
			</div>
			
			<!-- Content with text left and Verstappen right -->
			<div class="welcome-header-content">
				<div class="welcome-header-left">
					<p class="welcome-subtitle">
						Légy részese a száguldó cirkusz felejthetetlen világának!<br>
						Ismerkedj meg a Formula 1 kiváló pilótáival, úttörő csapataival és tanulj a legjobbaktól!<br>
						Nincs más dolgod, mind jelentkezni nálunk, és mi segítünk megvalósítani álmaidat!<br>
					<br><br>
					A hősöd Ayrton Senna, Michael Schumacher vagy Max Verstappen?<br>
					Tanulj róluk nálunk, légy te is a következő bajnok!
										Ehhez nincs más dolgod, mint regisztrálni <a href="{{ route('register') }}" class="welcome-register-link">ITT</a> és beiratkozni tanfolyamaink egyikére!
				</p>
			</div>
			
			<div class="welcome-header-right">
				<img src="https://media.formula1.com/image/upload/c_lfill,w_3392/q_auto/v1740000000/content/dam/fom-website/manual/Misc/Verstappenbacktobacktitles/verstappen-hero.webp" alt="Max Verstappen" class="welcome-verstappen-img">
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
