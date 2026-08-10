<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEKA - Sistem Informasi Pelayanan Bidang Peternakan</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f4f6f9 !important;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Layout Main Wrapper */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Custom Sidebar */
        .custom-sidebar {
            width: 260px;
            background-color: #146c43 !important;
            color: #ffffff !important;
            flex-shrink: 0;
            padding: 20px 15px;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 100;
        }

        .custom-sidebar a {
            color: #ffffff !important;
            text-decoration: none !important;
            display: block;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            position: relative;
            z-index: 101;
            cursor: pointer !important;
        }

        .custom-sidebar a:hover, .custom-sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2) !important;
            padding-left: 18px;
        }

        .sidebar-title {
            color: #ffffff !important;
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }

        .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.72rem;
            text-align: center;
            display: block;
            margin-top: 4px;
            margin-bottom: 15px;
        }

        .sidebar-section-label {
            color: rgba(255, 255, 255, 0.6) !important;
            font-size: 0.7rem;
            font-weight: bold;
            letter-spacing: 0.8px;
            padding: 8px 12px 4px 12px;
            display: block;
        }

        .sidebar-hr {
            border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
            margin: 10px 0;
        }

        /* Content Area */
        .main-content {
            flex-grow: 1;
            padding: 25px;
            background-color: #f4f6f9;
        }

        .top-navbar {
            background-color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="app-container">
    <!-- SIDEBAR -->
    <div class="custom-sidebar">
        <div class="sidebar-title">SIPEKA</div>
        <span class="sidebar-subtitle">Sistem Informasi Pelayanan Bidang Peternakan</span>

        <hr class="sidebar-hr">

        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>

        <hr class="sidebar-hr">

        <span class="sidebar-section-label">DATA PETERNAKAN</span>
        <a href="{{ url('/populasi') }}" class="{{ request()->is('populasi*') ? 'active' : '' }}">
            🐄 Populasi Ternak
        </a>
        <a href="{{ route('inseminasi.index') }}" class="{{ request()->routeIs('inseminasi.*') ? 'active' : '' }}">
            💉 Inseminasi Buatan
        </a>
        <a href="{{ route('pengobatan.index') }}" class="{{ request()->routeIs('pengobatan.*') ? 'active' : '' }}">
            🏥 Pengobatan & Vaksinasi
        </a>

        <hr class="sidebar-hr">

        <span class="sidebar-section-label">PELAYANAN</span>
        <a href="#">📄 SKKH</a>
        <a href="#">📑 Surat Rekomendasi Peternakan</a>
        <a href="#">📜 Surat Keterangan Usaha</a>
        <a href="#">🏢 Rekomendasi NKV</a>
        <a href="#">✅ Sertifikasi GBP/GHP/GFP</a>

        <hr class="sidebar-hr">

        <a href="#">🖼️ Galeri</a>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="main-content">
        <!-- TOP NAVBAR -->
        <div class="top-navbar">
            <span style="color: #495057; font-weight: 600;">
                Dinas Pertanian dan Ketahanan Pangan Kabupaten Pandeglang
            </span>
            
            <!-- ADMIN MENU DROPDOWN -->
            <div class="dropdown">
                <button class="btn btn-outline-success dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                    👤 Admin
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Master Data</h6></li>
                    <li><a class="dropdown-item" href="#">🗺️ Master Kecamatan</a></li>
                    <li><a class="dropdown-item" href="#">🏘️ Master Desa</a></li>
                    <li><a class="dropdown-item" href="#">📋 Master Layanan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- CONTENT DARI DASHBOARD / HALAMAN LAIN -->
        @yield('content')

        <footer class="text-center mt-5 mb-3 text-muted">
            <hr>
            <small>© {{ date('Y') }} SIPEKA - Sistem Informasi Pelayanan Bidang Peternakan</small>
        </footer>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>