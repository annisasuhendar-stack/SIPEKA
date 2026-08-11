@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0">📊 Dashboard SIPEKA</h3>
    <span class="badge bg-success px-3 py-2 fs-6">Sistem Aktif</span>
</div>
<!-- 6 STAT CARDS MODERN -->
<div class="row g-3 mb-4">
    <!-- Card 1: Populasi -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-primary bg-gradient text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">Populasi</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalPopulasi ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-bar-chart-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 2: SKKH -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-success bg-gradient text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">SKKH</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalSkkh ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-file-earmark-text-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
<!-- Card 3: Inseminasi Buatan -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-info bg-gradient text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">Inseminasi</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalIb ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-node-plus-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 4: Pengobatan & Vaksinasi -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-warning bg-gradient text-white h-100">
           <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">Pengobatan</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalPengobatan ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-hospital-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
<!-- Card 5: Rekomendasi NKV -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-secondary bg-gradient text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">NKV</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalNkv ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-building-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
<!-- Card 6: Sertifikasi -->
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm rounded-3 bg-dark bg-gradient text-white h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.7rem;">Sertifikasi</small>
                        <h4 class="fw-bold m-0 mt-1">{{ $totalSertifikasi ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-patch-check-fill fs-2 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION GRAFIK CAROUSEL & INFORMASI -->
<div class="row g-4 mb-4">
    <!-- Carousel Grafik Auto Slide -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                <h5 class="fw-bold m-0 text-success">📈 Statistik Pelayanan & Peternakan</h5>
                <small class="text-muted"><i class="bi bi-arrow-repeat me-1"></i>Otomatis ganti tiap 5 dtk</small>
            </div>
            <div class="card-body">
                <div id="dashboardCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        <!-- Slide 1: Populasi -->
                        <div class="carousel-item active">
                            <h6 class="text-center text-muted fw-semibold mb-3">Grafik Populasi Ternak</h6>
                            <div id="chartPopulasi" style="min-height: 280px;"></div>
                        </div>
                        <!-- Slide 2: SKKH -->
                        <div class="carousel-item">
                            <h6 class="text-center text-muted fw-semibold mb-3">Grafik Pelayanan SKKH</h6>
                            <div id="chartSkkh" style="min-height: 280px;"></div>
                        </div>
                        <!-- Slide 3: Inseminasi Buatan -->
                        <div class="carousel-item">
                            <h6 class="text-center text-muted fw-semibold mb-3">Grafik Inseminasi Buatan (IB)</h6>
                            <div id="chartIb" style="min-height: 280px;"></div>
                        </div>
                        <!-- Slide 4: Pengobatan -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev" style="width: 5%;">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next" style="width: 5%;">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Selamat Datang -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-success text-white py-3 rounded-top-3">
                <h5 class="m-0 fw-bold"><i class="bi bi-info-circle me-2"></i>SIPEKA Info</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold text-dark">Dinas Pertanian dan Ketahanan Pangan</h6>
                <p class="text-muted small">Kabupaten Pandeglang</p>
                <hr>
                <p class="text-secondary small">
                    Selamat datang di sistem pelayanan terpadu. Gunakan menu sidebar untuk navigasi data populasi, penerbitan dokumen pelayanan peternakan, serta manajemen master data.
                </p>
                <div class="alert alert-light border mt-3 mb-0 p-2 text-center">
                    <small class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Sistem Terkoneksi (Railway)</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ACTIVITAS TERBARU -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold m-0 text-dark"><i class="bi bi-clock-history me-2"></i>Aktivitas Pelayanan Terbaru</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Jenis Layanan</th>
                        <th>Pemohon / Pemilik</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-3" colspan="5">
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                                Belum ada aktivitas data pelayanan terbaru.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var dataPopulasi = {{ json_encode(array_map('intval', $dataPopulasi ?? [0, 0, 0, 0, 0, 0, 0])) }};
        var dataSkkh     = {{ json_encode(array_map('intval', $dataSkkh ?? [0, 0, 0, 0, 0, 0])) }};
        var dataIb       = {{ json_encode(array_map('intval', $dataIb ?? [0, 0, 0, 0])) }};
// 1. Chart Populasi (Dengan Kategori Unggas Tambahan)
        var chartPopulasi = new ApexCharts(document.querySelector("#chartPopulasi"), {
            chart: { type: 'bar', height: 260 },
            series: [{ name: 'Jumlah Data', data: dataPopulasi }],
            xaxis: { categories: ['Sapi', 'Kambing', 'Domba', 'Kerbau', 'Ayam', 'Bebek', 'Itik'] },
            colors: ['#0d6efd']
        });
        chartPopulasi.render();
        // 2. Chart SKKH
        var chartSkkh = new ApexCharts(document.querySelector("#chartSkkh"), {
            chart: { type: 'line', height: 260 },
            series: [{ name: 'SKKH Terbit', data: dataSkkh }],
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'] },
            colors: ['#198754']
        });
        chartSkkh.render();
        // 3. Chart IB (Pie Chart)
        var chartIb = new ApexCharts(document.querySelector("#chartIb"), {
            chart: { type: 'pie', height: 260, width: '100%' },
            series: dataIb,
            labels: ['Sapi', 'Kambing', 'Domba', 'Kerbau'],
            colors: ['#0dcaf0', '#ffc107', '#198754', '#6c757d']
        });
        chartIb.render();
        // Refresh ApexCharts saat Carousel Bergeser
        var carouselEl = document.getElementById('dashboardCarousel');
        if (carouselEl) {
            carouselEl.addEventListener('slid.bs.carousel', function () {
                window.dispatchEvent(new Event('resize'));
            });
        }
    });
</script>
@endsection 

