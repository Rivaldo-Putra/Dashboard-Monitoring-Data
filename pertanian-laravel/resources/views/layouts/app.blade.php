<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pertanian Laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #07c539 !important; }
        .navbar-brand, .nav-link { color: white !important; font-weight: 600; }
        .container-fluid { margin-top: 30px; }
        .btn-tambah {
            background: #07c539; color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: bold;
        }
        .btn-tambah:hover { background: #059669; }
        .table-data img { max-width: 100%; height: auto; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('categories.index') }}">🌾 Pertanian Laravel</a>
            <div>
                <a href="{{ route('categories.create') }}" class="btn btn-light me-3">+ Tambah</a>
                <a href="{{ route('categories.pdf') }}" target="_blank" class="btn btn-danger">PDF</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>