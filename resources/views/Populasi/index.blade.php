@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Populasi Ternak</h3>
    <div>
        <!-- Tombol Export Excel -->
        <a href="{{ route('populasi.export') }}" class="btn btn-success me-2">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
        </a>
        <a href="{{ route('populasi.create') }}" class="btn btn-primary">
            + Tambah Data
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Jenis Ternak</th>
                        <th>Jumlah</th>
                        <th>Tahun</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($populasi as $index => $item)
                        <tr>
                            <td class="ps-3">{{ $index + 1 }}</td>
                            <!-- Panggil kolom nama_kecamatan dan nama_desa -->
                            <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td>{{ $item->desa->nama_desa ?? '-' }}</td>
                            <td>{{ $item->jenis_ternak ?? $item->jenis_hewan }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td class="text-center">
                                <a href="{{ route('populasi.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>
                                <form action="{{ route('populasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data populasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection