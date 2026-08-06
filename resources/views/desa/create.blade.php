@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header bg-success text-white">
        Tambah Desa
    </div>

    <div class="card-body">

        <form action="{{ route('desa.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Kecamatan</label>

                <select name="kecamatan_id" class="form-control" required>

                    <option value="">-- Pilih Kecamatan --</option>

                    @foreach($kecamatans as $kecamatan)

                    <option value="{{ $kecamatan->id }}">
                        {{ $kecamatan->nama_kecamatan }}
                    </option>

                    @endforeach

                </select>
<li class="nav-item">
    <a href="{{ route('desa.index') }}" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>Master Desa</p>
    </a>
</li>
            </div>

            <div class="mb-3">
                <label>Nama Desa</label>

                <input
                    type="text"
                    name="nama_desa"
                    class="form-control"
                    required>

            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('desa.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection