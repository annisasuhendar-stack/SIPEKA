@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">📋 Master Layanan</h4>

        <button class="btn btn-light btn-sm">
            + Tambah Layanan
        </button>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead class="table-success">

                <tr>

                    <th width="60">No</th>

                    <th>Nama Layanan</th>

                    <th width="120">Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($layanans as $layanan)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $layanan->nama_layanan }}</td>

                    <td>
                        @if($layanan->aktif)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                        @endif
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection