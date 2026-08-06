<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEKA - Bidang Peternakan Kab. Pandeglang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background: #198754;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .content {
            padding: 25px;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid px-4">
        <span class="navbar-brand brand">
            🐄 SIPEKA
            <small class="d-block" style="font-size: 12px; opacity: 0.9;">
                Bidang Peternakan Kabupaten Pandeglang
            </small>
        </span>

        <span class="text-white d-none d-md-inline">
            Sistem Informasi Pelayanan Bidang Peternakan
        </span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-2 sidebar pt-4">
            <a href="/dashboard">🏠 Dashboard</a>
            <a href="/layanan">📋 Master Layanan</a>
            <a href="{{ route('kecamatan.index') }}">🗺️ Master Kecamatan</a>
            <a href="{{ route('desa.index') }}">🏘️ Master Desa</a>
            <a href="{{ route('populasi.index') }}">🐄 Populasi Ternak</a>
            <a href="#">😊 Survey</a>
            <a href="#">📊 Laporan</a>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-10 content">
            @yield('content')

            <footer class="text-center mt-5 mb-3 text-muted">
                <hr>
                © {{ date('Y') }} SIPEKA - Sistem Informasi Pelayanan Bidang Peternakan
            </footer>
        </div>
    </div>
</div>

</body>
</html>