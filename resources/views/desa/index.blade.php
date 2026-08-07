@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h2>Master Desa</h2>

        <a href="{{ route('desa.create') }}" class="btn btn-success">
            + Tambah Desa
        </a>
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
                <th>Nama Desa</th>
            </tr>
        </thead>

        <tbody>

        @forelse($desas as $desa)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $desa->kecamatan->nama_kecamatan }}</td>
            <td>{{ $desa->nama_desa }}</td>
        </tr>

        @empty

        <tr>
            <td colspan="3" class="text-center">
                Belum ada data
            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection