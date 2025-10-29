<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
</head>
<body>
    <h1>Test Page Working!</h1>
    <p>Pilots count: {{ count($pilots ?? []) }}</p>
    <p>Results count: {{ count($results ?? []) }}</p>
    <p>GPs count: {{ count($gps ?? []) }}</p>
    
    @if(isset($pilots) && count($pilots) > 0)
        <h3>First 5 pilots:</h3>
        <ul>
            @foreach($pilots->take(5) as $pilot)
                <li>{{ $pilot->pilot_id }} - {{ $pilot->name }}</li>
            @endforeach
        </ul>
    @else
        <p>No pilots data found!</p>
    @endif
    
    <hr>
    <h3>Database Setup Instructions:</h3>
    <ol>
        <li>Create MySQL database: f1_championship</li>
        <li>Run migrations: <code>php artisan migrate</code></li>
        <li>Import data: <code>php artisan f1:import</code></li>
    </ol>
</body>
</html>