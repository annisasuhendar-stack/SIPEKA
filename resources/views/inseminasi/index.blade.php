@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Inseminasi Buatan</h2>

    <div>
        <a href="{{ route('inseminasi.export') }}" class="btn btn-success me-2">
            Export Excel
        </a>
        <a href="{{ route('inseminasi.create') }}" class="btn btn-primary">
            + Tambah Data
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Jenis Hewan</th>
                        <th>Identitas Pemilik</th>
                        <th>Alamat</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->jenis_hewan }}
                            </td>

                            <td>
                                {{ $item->identitas_pemilik }}
                            </td>

                            <td>
                                {{ $item->alamat }}
                            </td>

                            <td>

                                <a href="{{ route('inseminasi.edit', $item->id) }}"
                                   class="btn btn-warning btn-sm">
                                    ✏ Edit
                                </a>

                                <form action="{{ route('inseminasi.destroy', $item->id) }}"
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
                            <td colspan="5" class="text-center">
                                Belum ada data inseminasi buatan
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection