@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengobatan & Vaksinasi</h1>
    <p class="text-muted">Kelola data pelayanan pengobatan dan vaksinasi ternak.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </button>
                <a href="{{ route('pengobatan.export') }}" class="btn btn-success btn-sm ms-1">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
            </div>
            <form action="{{ route('pengobatan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari data..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Pemilik</th>
                            <th>Jenis Hewan / Ternak</th>
                            <th>Jenis Layanan</th>
                            <th>Jenis Penyakit</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengobatans as $index => $item)
                        <tr>
                            <td>{{ $pengobatans->firstItem() + $index }}</td>
                            <td>{{ $item->nama_pemilik }}</td>
                            <td>{{ $item->jenis_hewan }}</td>
                            <td>
                                <span class="badge {{ $item->jenis_layanan == 'Vaksinasi' ? 'bg-info' : 'bg-warning' }}">
                                    {{ $item->jenis_layanan }}
                                </span>
                            </td>
                            <td>{{ $item->jenis_penyakit ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                                <form action="{{ route('pengobatan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('pengobatan.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data Pengobatan & Vaksinasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Pemilik</label>
                                                <input type="text" name="nama_pemilik" class="form-control" value="{{ $item->nama_pemilik }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis Hewan / Ternak</label>
                                                <input type="text" name="jenis_hewan" class="form-control" value="{{ $item->jenis_hewan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis Layanan</label>
                                                <select name="jenis_layanan" class="form-select" required>
                                                    <option value="Vaksinasi" {{ $item->jenis_layanan == 'Vaksinasi' ? 'selected' : '' }}>Vaksinasi</option>
                                                    <option value="Pengobatan" {{ $item->jenis_layanan == 'Pengobatan' ? 'selected' : '' }}>Pengobatan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis Penyakit</label>
                                                <input type="text" name="jenis_penyakit" class="form-control" value="{{ $item->jenis_penyakit }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $pengobatans->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pengobatan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pengobatan & Vaksinasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" placeholder="Masukkan nama pemilik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Hewan / Ternak</label>
                        <input type="text" name="jenis_hewan" class="form-control" placeholder="Contoh: Sapi, Kambing, Ayam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Layanan</label>
                        <select name="jenis_layanan" class="form-select" required>
                            <option value="Pengobatan">Pengobatan</option>
                            <option value="Vaksinasi">Vaksinasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Penyakit</label>
                        <input type="text" name="jenis_penyakit" class="form-control" placeholder="Contoh: PMK, Parasit, Flu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection