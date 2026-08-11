@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-success m-0">
            📄 Data SKKH
        </h4>

        <div>
            <button type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                + Tambah SKKH
            </button>
        </div>
    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- TABEL --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No</th>
                            <th>Nomor Surat</th>
                            <th>Identitas Pemilik</th>
                            <th>Jenis Hewan / Ternak</th>
                            <th>Tujuan Pengiriman</th>
                            <th>Dokumen</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($skkhs as $index => $item)

                            <tr>

                                <td class="ps-3">
                                    {{ $skkhs->firstItem() + $index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $item->nomor_surat ?? '-' }}
                                </td>

                                <td>
                                    <strong>{{ $item->nama_pemilik }}</strong>

                                    @if($item->identitas_pemilik)
                                        <br>
                                        <small class="text-muted">
                                            {{ $item->identitas_pemilik }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    {{ $item->jenis_hewan }}
                                </td>

                                <td>
                                    {{ $item->tujuan_pengiriman ?? '-' }}
                                </td>

                                <td>

                                    @if($item->dokumen)

                                        <a href="{{ asset('storage/' . $item->dokumen) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-success">
                                            📎 Lihat Dokumen
                                        </a>

                                    @else

                                        <span class="text-muted">
                                            Belum ada
                                        </span>

                                    @endif

                                </td>

                                <td class="text-center">

                                    {{-- EDIT --}}
                                    <button type="button"
                                            class="btn btn-sm btn-outline-warning me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->id }}">
                                        Edit
                                    </button>


                                    {{-- HAPUS --}}
                                    <form action="{{ route('skkh.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data SKKH ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>


                            {{-- MODAL EDIT --}}
                            <div class="modal fade"
                                 id="modalEdit{{ $item->id }}"
                                 tabindex="-1">

                                <div class="modal-dialog">

                                    <form action="{{ route('skkh.update', $item->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title fw-bold">
                                                    Edit Data SKKH
                                                </h5>

                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                </button>

                                            </div>


                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Nomor Surat
                                                    </label>

                                                    <input type="text"
                                                           name="nomor_surat"
                                                           class="form-control"
                                                           value="{{ $item->nomor_surat }}">
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Nama Pemilik
                                                    </label>

                                                    <input type="text"
                                                           name="nama_pemilik"
                                                           class="form-control"
                                                           value="{{ $item->nama_pemilik }}"
                                                           required>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Identitas Pemilik
                                                    </label>

                                                    <textarea name="identitas_pemilik"
                                                              class="form-control"
                                                              rows="2">{{ $item->identitas_pemilik }}</textarea>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Jenis Hewan / Ternak
                                                    </label>

                                                    <input type="text"
                                                           name="jenis_hewan"
                                                           class="form-control"
                                                           value="{{ $item->jenis_hewan }}"
                                                           required>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Tujuan Pengiriman
                                                    </label>

                                                    <input type="text"
                                                           name="tujuan_pengiriman"
                                                           class="form-control"
                                                           value="{{ $item->tujuan_pengiriman }}">
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Upload Dokumen
                                                    </label>

                                                    <input type="file"
                                                           name="dokumen"
                                                           class="form-control"
                                                           accept=".pdf,.jpg,.jpeg,.png">

                                                    <small class="text-muted">
                                                        PDF/JPG/PNG, maksimal 5 MB.
                                                    </small>
                                                </div>

                                            </div>


                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Batal
                                                </button>

                                                <button type="submit"
                                                        class="btn btn-success">
                                                    Simpan Perubahan
                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center py-5 text-muted">

                                    <div style="font-size:40px;">
                                        📄
                                    </div>

                                    Belum ada data SKKH.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        @if($skkhs->hasPages())

            <div class="card-footer bg-white">
                {{ $skkhs->links() }}
            </div>

        @endif

    </div>

</div>


{{-- ================================================= --}}
{{-- MODAL TAMBAH SKKH --}}
{{-- ================================================= --}}

<div class="modal fade"
     id="modalTambah"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('skkh.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">
                        Tambah Data SKKH
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Nomor Surat
                        </label>

                        <input type="text"
                               name="nomor_surat"
                               class="form-control"
                               placeholder="Contoh: 524/001/SKKH/2026">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Nama Pemilik
                        </label>

                        <input type="text"
                               name="nama_pemilik"
                               class="form-control"
                               placeholder="Masukkan nama pemilik"
                               required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Identitas Pemilik
                        </label>

                        <textarea name="identitas_pemilik"
                                  class="form-control"
                                  rows="2"
                                  placeholder="NIK / alamat / identitas lainnya"></textarea>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Jenis Hewan / Ternak
                        </label>

                        <input type="text"
                               name="jenis_hewan"
                               class="form-control"
                               placeholder="Contoh: Sapi"
                               required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Tujuan Pengiriman
                        </label>

                        <input type="text"
                               name="tujuan_pengiriman"
                               class="form-control"
                               placeholder="Contoh: Serang, Banten">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Upload Dokumen
                        </label>

                        <input type="file"
                               name="dokumen"
                               class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png">

                        <small class="text-muted">
                            PDF/JPG/PNG, maksimal 5 MB.
                        </small>
                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan Data
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection