@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-success shadow">
            <div class="card-body">
                <h5>Total Layanan</h5>
                <h1>{{ $totalLayanan }}</h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body">
                <h5>Populasi Ternak</h5>
                <h1>{{ number_format($totalPopulasi) }}</h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning shadow">
            <div class="card-body">
                <h5>Total Kecamatan</h5>
                <h1>{{ $totalKecamatan }}</h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-danger shadow">
            <div class="card-body">
                <h5>Total Desa</h5>
                <h1>{{ $totalDesa }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4 shadow">
    <div class="card-header bg-success text-white">
        Selamat Datang di SIPEKA
    </div>
    <div class="card-body">
        <h4>Sistem Informasi Pelayanan Bidang Peternakan</h4>
        <p>Dinas Pertanian dan Ketahanan Pangan Kabupaten Pandeglang</p>
        <hr>
        <p>
            Gunakan menu di sebelah kiri untuk mengelola data pelayanan,
            populasi ternak, survey kepuasan masyarakat, dan laporan.
        </p>
    </div>
</div>

<div class="card mt-4 shadow">
    <div class="card-header bg-success text-white">
        Populasi Ternak per Kecamatan
    </div>
    <div class="card-body">
        <canvas id="grafikPopulasi" height="100"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const labels = @json($grafikPopulasi->pluck('nama_kecamatan'));
    const data = @json($grafikPopulasi->pluck('total'));

    const ctx = document.getElementById('grafikPopulasi');

    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Populasi',
                    data: data,
                    backgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection