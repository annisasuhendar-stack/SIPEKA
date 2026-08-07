@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🗺️ Data Master Kecamatan</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Kecamatan
    </button>
</div>

{{-- Notifikasi Sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th style="width: 60px">#</th>
                    <th>Kode Kecamatan</th>
                    <th>Nama Kecamatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kecamatan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kode_kecamatan }}</span></td>
                        <td class="fw-bold">{{ $item->nama_kecamatan }}</td>
                        
    </a>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Data kecamatan belum ada. Silakan tambah data baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Form Tambah Data --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Kecamatan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kecamatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_kecamatan" class="form-label">Kode Kecamatan</label>
                        <input type="text" name="kode_kecamatan" class="form-control" placeholder="Contoh: KEC-01 atau 360101" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kecamatan" class="form-label">Nama Kecamatan</label>
                        <input type="text" name="nama_kecamatan" class="form-control" placeholder="Contoh: Pandeglang" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Bootstrap JS untuk Modal & Alert --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
@endsection