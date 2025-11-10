@extends('layouts.landed-layout')

@section('title', 'Főoldal')

{{-- Minden stílus az f1-styles.css-ben van --}}

@section('content')
<div class="white-content-wrapper">
	<div class="welcome-logo-container">
		<img src="{{ asset('images/359-3592497_file-f1-svg-f1-logo-png-transparent-png.png') }}" alt="Formula 1 Logo" class="welcome-logo">
	</div>
	
	<div class="content-section">
		<p class="welcome-subtitle">
			<strong class="red-title">Üdvözlünk az F1 Akadémián, ahol a sebesség, a szenvedély és a történelem találkozik!</strong><br><br>
			
			<span class="normal-text">Oldalunk célja, hogy elhozzuk neked a Formula–1 aranykorának minden pillanatát – az 1950-es évektől egészen 2006-ig. Merülj el a sportág gyökereiben, és fedezd fel, hogyan vált a benzingőzös álmokból a világ legizgalmasabb versenysorozata!</span><br><br>
			
			<span class="normal-text">Ismerd meg a legendás pilótákat, akik örökre beírták nevüket a történelembe – Fangio, Lauda, Senna, Prost, Schumacher és sokan mások.
			Fedezd fel a csapatokat és konstrukciókat, amelyek újra és újra forradalmasította a versenyzést, a mérnöki zsenialitást és az emberi kitartást.</span>
		</p>
		
		<div class="full-width-image">
			<img src="https://cparici.com/wp-content/uploads/2025/08/cparici-2025-08-01T205416.688.jpg" alt="F1 Historical Moment" class="historical-image">
		</div>
		
		<p class="welcome-subtitle">
			<span class="normal-text">Az F1 Akadémia nem csupán egy adatbázis – ez egy időutazás, ahol minden statisztika mögött egy történet, minden győzelem mögött egy ember, és minden verseny mögött egy álom áll.
			Böngéssz a futamok, szezonok és pályák között, és ismerd meg, hogyan született meg a modern autósport, amit ma milliók követnek lélegzetvisszafojtva.</span><br><br>
		</p>
	</div>
	
	<div class="content-with-image">
		<div class="content-text">
			<p class="welcome-subtitle">
				<strong>A hősöd Ayrton Senna, Michael Schumacher vagy Max Verstappen?</strong><br>
				<span class="normal-text">
				Tanulj róluk nálunk – nézd meg, hogyan emelkedtek fel, hogyan győztek, és mi tette őket legendává.
				Engedd, hogy a múlt inspiráljon, és ha te is érzed a sebesség hívását, légy részese a történetnek!<br><br>
				Nincs más dolgod, mint regisztrálni <a href="{{ route('register') }}" class="welcome-register-link">ITT</a>, és beiratkozni tanfolyamaink egyikére, ahol megmutatjuk, miért több a Formula–1 puszta versenynél.
				Ez egy életérzés. Egy örök szenvedély. Egy közösség, ahol minden rajongó otthonra talál.<br>
				</span>
				<strong>Csatlakozz az F1 Akadémiához, és éld át újra a száguldó cirkusz történelmét – körönként, évadonként, legendáról legendára!</strong>
			</p>
		</div>
		<div class="content-image">
			<img src="https://media.formula1.com/image/upload/c_lfill,w_3392/q_auto/v1740000000/content/dam/fom-website/manual/Misc/Verstappenbacktobacktitles/verstappen-hero.webp" alt="Max Verstappen" class="welcome-verstappen-img">
		</div>
	</div>
	<img src="https://www.goodwood.com/globalassets/.road--racing/event-coverage/fos/2025/06-june/champions-announcement/fos-champions-graphic.png?rxy=0.5,0.5&width=1280&height=720" alt="history" class="historical-image">
</div>

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
