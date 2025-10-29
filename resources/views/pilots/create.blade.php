<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New F1 Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">🏎️ Add New F1 Driver</h1>
                
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pilots.store') }}" method="POST">
                            @csrf
                            <!-- Form fields will be added here -->
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('pilots.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Add Driver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>