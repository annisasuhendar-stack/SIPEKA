@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Surat Keterangan Usaha Peternakan
            </h4>
            <p class="text-muted mb-0">
                Data surat keterangan usaha peternakan
            </p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i>
            Tambah Data
        </button>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Identitas Pemilik</th>
                            <th>Jenis Komoditi/Usaha</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($suratKeteranganUsahas as $item)

                            <tr>
                                <td>
                                    {{ $loop->iteration + ($suratKeteranganUsahas->currentPage() - 1) * $suratKeteranganUsahas->perPage() }}
                                </td>

                                <td>
                                    {{ $item->nomor_surat ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->identitas_pemilik ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->jenis_komoditi_usaha }}
                                </td>

                                <td>
                                    @if($item->dokumen)

                                        <a href="{{ rtrim(env('SUPABASE_URL'), '/') }}/storage/v1/object/public/{{ env('SUPABASE_BUCKET') }}/{{ $item->dokumen }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Lihat Dokumen
                                        </a>

                                    @else

                                        <span class="text-muted">
                                            Tidak ada
                                        </span>

                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- EDIT --}}
                                        <button
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('surat-keterangan-usaha.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data Surat Keterangan Usaha.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $suratKeteranganUsahas->links() }}
            </div>

        </div>
    </div>

</div>


{{-- ===================================================== --}}
{{-- MODAL TAMBAH --}}
{{-- ===================================================== --}}

<div class="modal fade" id="modalTambah" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{ route('surat-keterangan-usaha.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Surat Keterangan Usaha
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nomor Surat
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   class="form-control">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Identitas Pemilik
                            </label>

                            <input type="text"
                                   name="identitas_pemilik"
                                   class="form-control">

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Jenis Komoditi/Usaha
                            </label>

                            <input type="text"
                                   name="jenis_komoditi_usaha"
                                   class="form-control"
                                   placeholder="Contoh: Peternakan Ayam">

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Upload Dokumen
                            </label>

                            <input type="file"
                                   name="dokumen"
                                   class="form-control"
                                   accept=".pdf,.jpg,.jpeg,.png">

                            <small class="text-muted">
                                Maksimal 5 MB. Format PDF, JPG, JPEG, PNG.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ===================================================== --}}
{{-- MODAL EDIT --}}
{{-- ===================================================== --}}

@foreach($suratKeteranganUsahas as $item)

<div class="modal fade"
     id="modalEdit{{ $item->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{ route('surat-keterangan-usaha.update', $item->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Surat Keterangan Usaha
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nomor Surat
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   class="form-control"
                                   value="{{ $item->nomor_surat }}">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Identitas Pemilik
                            </label>

                            <input type="text"
                                   name="identitas_pemilik"
                                   class="form-control"
                                   value="{{ $item->identitas_pemilik }}">

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Jenis Komoditi/Usaha
                            </label>

                            <input type="text"
                                   name="jenis_komoditi_usaha"
                                   class="form-control"
                                   value="{{ $item->jenis_komoditi_usaha }}">

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Ganti Dokumen
                            </label>

                            <input type="file"
                                   name="dokumen"
                                   class="form-control"
                                   accept=".pdf,.jpg,.jpeg,.png">

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti dokumen.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach

@endsection