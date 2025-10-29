@extends('layouts.eventually-layout')

@section('title', 'F1 History - Championship Database 2025')

@section('content')
        <!-- Navigation -->
        <nav id="nav" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); padding: 1em 0;">
            <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2em;">
                <div style="color: #ff6b6b; font-weight: bold; font-size: 1.2em;">🏁 F1 2025</div>
                <ul style="display: flex; list-style: none; margin: 0; padding: 0; gap: 2em;">
                    <li><a href="{{ route('home') }}" style="color: white; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; transition: all 0.3s;">Home</a></li>
                    <li><a href="{{ route('history') }}" style="color: #ff6b6b; text-decoration: none; padding: 0.5em 1em; border-radius: 5px; background: rgba(255,107,107,0.2);">F1 History</a></li>
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
            <h1>🏁 F1 Championship Database</h1>
            <p>Explore the complete history of Formula 1<br />
            Drivers, Results, and Grand Prix data from our archive</p>
        </header>

        <!-- Statistics Overview -->
        <div style="display: flex; justify-content: center; gap: 2em; margin: 2em 0; flex-wrap: wrap;">
            <div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 15px; min-width: 150px;">
                <div style="font-size: 2.5em; margin-bottom: 0.5em; color: #ff6b6b;">{{ count($pilots) }}</div>
                <h3 style="margin: 0; color: white; font-size: 1em;">Drivers</h3>
            </div>
            
            <div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 15px; min-width: 150px;">
                <div style="font-size: 2.5em; margin-bottom: 0.5em; color: #ff6b6b;">{{ count($results) }}</div>
                <h3 style="margin: 0; color: white; font-size: 1em;">Results</h3>
            </div>
            
            <div style="text-align: center; padding: 1.5em; background: rgba(255,255,255,0.05); border-radius: 15px; min-width: 150px;">
                <div style="font-size: 2.5em; margin-bottom: 0.5em; color: #ff6b6b;">{{ count($gps) }}</div>
                <h3 style="margin: 0; color: white; font-size: 1em;">Grand Prix</h3>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2em;">
            <div style="display: flex; justify-content: center; margin-bottom: 2em;">
                <div style="background: rgba(255,255,255,0.05); border-radius: 25px; padding: 0.5em; backdrop-filter: blur(10px);">
                    <button onclick="showTab('drivers')" id="driversBtn" style="padding: 0.8em 2em; background: #ff6b6b; border: none; border-radius: 20px; color: white; font-weight: bold; margin: 0 0.2em; cursor: pointer; transition: all 0.3s;">
                        👨‍🏆 Drivers
                    </button>
                    <button onclick="showTab('results')" id="resultsBtn" style="padding: 0.8em 2em; background: transparent; border: none; border-radius: 20px; color: white; font-weight: bold; margin: 0 0.2em; cursor: pointer; transition: all 0.3s;">
                        🏆 Results
                    </button>
                    <button onclick="showTab('grandprix')" id="grandprixBtn" style="padding: 0.8em 2em; background: transparent; border: none; border-radius: 20px; color: white; font-weight: bold; margin: 0 0.2em; cursor: pointer; transition: all 0.3s;">
                        🏁 Grand Prix
                    </button>
                </div>
            </div>

            <!-- Drivers Tab -->
            <div id="driversTab" class="tab-content" style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 2em; backdrop-filter: blur(10px);">
                <h2 style="color: #ff6b6b; margin-bottom: 1.5em; text-align: center;">🏎️ F1 Drivers Database</h2>
                <div style="overflow-x: auto; max-height: 500px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; color: white;">
                        <thead>
                            <tr style="background: rgba(255,107,107,0.2); position: sticky; top: 0;">
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">ID</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Driver Name</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Gender</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Birth Date</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Nationality</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pilots as $index => $pilot)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); {{ $index % 2 == 0 ? 'background: rgba(255,255,255,0.02);' : '' }}">
                                <td style="padding: 0.8em;">{{ $pilot->pilot_id }}</td>
                                <td style="padding: 0.8em; font-weight: bold;">{{ $pilot->name }}</td>
                                <td style="padding: 0.8em;">{{ $pilot->gender == 'F' ? '👨 Male' : '👩 Female' }}</td>
                                <td style="padding: 0.8em;">{{ $pilot->birth_date->format('Y.m.d') }}</td>
                                <td style="padding: 0.8em;">{{ $pilot->nationality }}</td>
                                <td style="padding: 0.8em;">
                                    <a href="{{ route('pilots.show', $pilot->pilot_id) }}" style="padding: 0.4em 0.8em; background: #ff6b6b; color: white; text-decoration: none; border-radius: 5px; font-size: 0.8em; margin-right: 0.5em;">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 2em; text-align: center; color: rgba(255,255,255,0.6);">No drivers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Results Tab -->
            <div id="resultsTab" class="tab-content" style="display: none; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 2em; backdrop-filter: blur(10px);">
                <h2 style="color: #ff6b6b; margin-bottom: 1.5em; text-align: center;">🏆 Race Results</h2>
                <div style="overflow-x: auto; max-height: 500px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; color: white;">
                        <thead>
                            <tr style="background: rgba(255,107,107,0.2); position: sticky; top: 0;">
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Date</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Driver ID</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Position</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Issue</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Team</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Car Type</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Engine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $index => $result)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); {{ $index % 2 == 0 ? 'background: rgba(255,255,255,0.02);' : '' }}">
                                <td style="padding: 0.8em;">{{ $result->race_date->format('Y.m.d') }}</td>
                                <td style="padding: 0.8em; font-weight: bold;">{{ $result->pilot_id }}</td>
                                <td style="padding: 0.8em;">
                                    @if($result->position)
                                        <span style="background: #ff6b6b; color: white; padding: 0.2em 0.6em; border-radius: 10px; font-size: 0.8em;">{{ $result->position }}</span>
                                    @else
                                        <span style="background: #666; color: white; padding: 0.2em 0.6em; border-radius: 10px; font-size: 0.8em;">DNF</span>
                                    @endif
                                </td>
                                <td style="padding: 0.8em;">{{ $result->issue ?: '-' }}</td>
                                <td style="padding: 0.8em;">{{ $result->team }}</td>
                                <td style="padding: 0.8em;">{{ $result->car_type }}</td>
                                <td style="padding: 0.8em;">{{ $result->engine }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding: 2em; text-align: center; color: rgba(255,255,255,0.6);">No results found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Grand Prix Tab -->
            <div id="grandprixTab" class="tab-content" style="display: none; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 2em; backdrop-filter: blur(10px);">
                <h2 style="color: #ff6b6b; margin-bottom: 1.5em; text-align: center;">🏁 Grand Prix Calendar</h2>
                <div style="overflow-x: auto; max-height: 500px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; color: white;">
                        <thead>
                            <tr style="background: rgba(255,107,107,0.2); position: sticky; top: 0;">
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Date</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Grand Prix</th>
                                <th style="padding: 1em; text-align: left; border-bottom: 2px solid #ff6b6b;">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gps as $index => $gp)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); {{ $index % 2 == 0 ? 'background: rgba(255,255,255,0.02);' : '' }}">
                                <td style="padding: 0.8em;">{{ $gp->race_date->format('Y.m.d') }}</td>
                                <td style="padding: 0.8em; font-weight: bold;">🏆 {{ $gp->name }} GP</td>
                                <td style="padding: 0.8em;">📍 {{ $gp->location }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding: 2em; text-align: center; color: rgba(255,255,255,0.6);">No Grand Prix data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div style="text-align: center; margin: 3em 0;">
            <a href="{{ route('home') }}" 
               style="display: inline-block; padding: 1em 2em; background: rgba(255,255,255,0.1); border-radius: 25px; color: inherit; text-decoration: none; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s;">
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

            function showTab(tabName) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.style.display = 'none';
                });
                
                // Remove active state from all buttons
                document.querySelectorAll('[id$="Btn"]').forEach(btn => {
                    btn.style.background = 'transparent';
                });
                
                // Show selected tab and set active button
                if (tabName === 'drivers') {
                    document.getElementById('driversTab').style.display = 'block';
                    document.getElementById('driversBtn').style.background = '#ff6b6b';
                } else if (tabName === 'results') {
                    document.getElementById('resultsTab').style.display = 'block';
                    document.getElementById('resultsBtn').style.background = '#ff6b6b';
                } else if (tabName === 'grandprix') {
                    document.getElementById('grandprixTab').style.display = 'block';
                    document.getElementById('grandprixBtn').style.background = '#ff6b6b';
                }
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
                    if (!this.closest('.dropdown') && !this.href.includes('history')) {
                        this.style.background = 'transparent';
                    }
                });
            });

            // Add hover effects to tab buttons
            document.querySelectorAll('[id$="Btn"]').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    if (this.style.background === 'transparent') {
                        this.style.background = 'rgba(255, 107, 107, 0.3)';
                    }
                });
                btn.addEventListener('mouseleave', function() {
                    if (this.style.background === 'rgba(255, 107, 107, 0.3)') {
                        this.style.background = 'transparent';
                    }
                });
            });
        </script>
@endsection