<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pilot['nev'] }} - F1 Driver Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .driver-header {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 2rem;
            border-radius: 0.5rem;
        }
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
        }
        .results-table {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Driver Header -->
                <div class="driver-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-1">🏎️ {{ $pilot['nev'] }}</h1>
                            <p class="mb-0 h5">ID: {{ $pilot['az'] }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="badge bg-light text-dark fs-6">{{ $pilot['nemzet'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Driver Info Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h6 class="text-muted">Gender</h6>
                            <p class="h5 mb-0">{{ $pilot['nem'] == 'F' ? 'Male' : 'Female' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h6 class="text-muted">Birth Date</h6>
                            <p class="h5 mb-0">{{ $pilot['szuldat'] ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h6 class="text-muted">Nationality</h6>
                            <p class="h5 mb-0">{{ $pilot['nemzet'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h6 class="text-muted">Race Results</h6>
                            <p class="h5 mb-0">{{ count($pilotResults) }} shown</p>
                        </div>
                    </div>
                </div>

                <!-- Race Results -->
                @if(count($pilotResults) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Race Results</h5>
                    </div>
                    <div class="card-body">
                        <div class="results-table">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Position</th>
                                        <th>Issue</th>
                                        <th>Team</th>
                                        <th>Car Type</th>
                                        <th>Engine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pilotResults as $result)
                                    <tr>
                                        <td>{{ $result['datum'] }}</td>
                                        <td>
                                            @if($result['helyezes'])
                                                <span class="badge bg-{{ $result['helyezes'] <= 3 ? 'success' : ($result['helyezes'] <= 10 ? 'warning' : 'secondary') }}">
                                                    P{{ $result['helyezes'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">DNF</span>
                                            @endif
                                        </td>
                                        <td>{{ $result['hiba'] ?: '-' }}</td>
                                        <td>{{ $result['csapat'] }}</td>
                                        <td>{{ $result['tipus'] }}</td>
                                        <td>{{ $result['motor'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-body text-center">
                        <h5>No race results found for this driver</h5>
                        <p class="text-muted">This driver may not have participated in any races yet.</p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('pilots.index') }}" class="btn btn-secondary">← Back to Drivers</a>
                    <div>
                        <a href="{{ route('pilots.edit', $pilot['az']) }}" class="btn btn-warning">Edit Driver</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>