@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Populasi Ternak</h2>

        <div>
            <!-- TOMBOL EXPORT EXCEL -->
            <a href="{{ route('populasi.export') }}" class="btn btn-success me-2">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>

            <!-- TOMBOL TAMBAH DATA -->
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


    <table class="table table-bordered table-striped">

        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Jenis Ternak</th>
                <th>Jumlah</th>
                <th>Tahun</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>


        <tbody>

        @forelse($data as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <!-- DIPERBAIKI: Mengambil nama dari relasi model -->
                <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>

                <!-- DIPERBAIKI: Mengambil nama dari relasi model -->
                <td>{{ $item->desa->nama_desa ?? '-' }}</td>

                <td>{{ $item->jenis_ternak }}</td>

                <td>{{ $item->jumlah }}</td>

                <td>{{ $item->tahun }}</td>


                <td>

                    <a href="{{ route('populasi.edit', $item->id) }}" 
                       class="btn btn-warning btn-sm">
                        ✏ Edit
                    </a>


                    <form action="{{ route('populasi.destroy', $item->id) }}" 
                          method="POST" 
                          class="d-inline">

                        @csrf
                        @method('DELETE')


                        <button type="submit" 
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                            🗑 Hapus
                        </button>


                    </form>

                </td>

            </tr>


        @empty

            <tr>
                <td colspan="7" class="text-center">
                    Belum ada data
                </td>
            </tr>


        @endforelse


        </tbody>


    </table>


</div>

@endsection