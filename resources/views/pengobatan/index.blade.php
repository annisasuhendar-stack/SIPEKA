@extends('layouts.app')

@section('content')

<div class="container-fluid">

```
{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-success m-0">
        🏥 Data Pengobatan & Vaksinasi
    </h4>

    <div>
        <a href="{{ route('pengobatan.export') }}" class="btn btn-success me-2">
            Export Excel
        </a>

        <button type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
            + Tambah Data
        </button>
    </div>
</div>


{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>
    </div>
@endif


{{-- TABLE --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle m-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-3" width="50">No</th>
                        <th>Nama Pemilik</th>
                        <th>Jenis Hewan / Ternak</th>
                        <th>Jenis Layanan</th>
                        <th>Jenis Penyakit</th>
                        <th>Tanggal Pelayanan</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengobatans as $index => $item)

                        <tr>

                            <td class="ps-3">
                                {{ $pengobatans->firstItem() + $index }}
                            </td>

                            <td class="fw-semibold">
                                {{ $item->nama_pemilik }}
                            </td>

                            <td>
                                {{ $item->jenis_hewan }}
                            </td>

                            <td>

                                <span class="badge {{ $item->jenis_layanan == 'Vaksinasi' ? 'bg-info' : 'bg-warning' }} text-dark">

                                    {{ $item->jenis_layanan }}

                                </span>

                            </td>

                            <td>
                                {{ $item->jenis_penyakit ?? '-' }}
                            </td>

                            <td>

                                @if($item->tanggal_pelayanan)
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelayanan)->format('d-m-Y') }}
                                @else
                                    -
                                @endif

                            </td>

                            <td class="text-center">

                                {{-- EDIT --}}
                                <button class="btn btn-sm btn-outline-warning me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}">
                                    Edit
                                </button>


                                {{-- DELETE --}}
                                <form action="{{ route('pengobatan.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
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

                                <form action="{{ route('pengobatan.update', $item->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title fw-bold">
                                                Edit Data Pengobatan & Vaksinasi
                                            </h5>

                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                            </button>

                                        </div>


                                        <div class="modal-body">

                                            {{-- NAMA PEMILIK --}}
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


                                            {{-- JENIS HEWAN --}}
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


                                            {{-- JENIS LAYANAN --}}
                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Jenis Layanan
                                                </label>

                                                <select name="jenis_layanan"
                                                        class="form-select"
                                                        required>

                                                    <option value="Vaksinasi"
                                                        {{ $item->jenis_layanan == 'Vaksinasi' ? 'selected' : '' }}>
                                                        Vaksinasi
                                                    </option>

                                                    <option value="Pengobatan"
                                                        {{ $item->jenis_layanan == 'Pengobatan' ? 'selected' : '' }}>
                                                        Pengobatan
                                                    </option>

                                                </select>

                                            </div>


                                            {{-- JENIS PENYAKIT --}}
                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Jenis Penyakit
                                                </label>

                                                <input type="text"
                                                       name="jenis_penyakit"
                                                       class="form-control"
                                                       value="{{ $item->jenis_penyakit }}">

                                            </div>


                                            {{-- TANGGAL PELAYANAN --}}
                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Tanggal Pelayanan
                                                </label>

                                                <input type="date"
                                                       name="tanggal_pelayanan"
                                                       class="form-control"
                                                       value="{{ $item->tanggal_pelayanan }}"
                                                       required>

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
                                class="text-center py-4 text-muted">

                                Belum ada data pengobatan atau vaksinasi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PAGINATION --}}
    @if($pengobatans->hasPages())

        <div class="card-footer bg-white d-flex justify-content-end">

            {{ $pengobatans->links() }}

        </div>

    @endif

</div>
```

</div>

{{-- ========================================================= --}}
{{-- MODAL TAMBAH DATA --}}
{{-- ========================================================= --}}

<div class="modal fade"
     id="modalTambah"
     tabindex="-1">

```
<div class="modal-dialog">

    <form action="{{ route('pengobatan.store') }}"
          method="POST">

        @csrf

        <div class="modal-content">


            {{-- HEADER MODAL --}}
            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Tambah Data Pengobatan & Vaksinasi
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            {{-- BODY MODAL --}}
            <div class="modal-body">


                {{-- NAMA PEMILIK --}}
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


                {{-- JENIS HEWAN --}}
                <div class="mb-3">

                    <label class="form-label">
                        Jenis Hewan / Ternak
                    </label>

                    <input type="text"
                           name="jenis_hewan"
                           class="form-control"
                           placeholder="Contoh: Sapi, Kambing, Ayam"
                           required>

                </div>


                {{-- JENIS LAYANAN --}}
                <div class="mb-3">

                    <label class="form-label">
                        Jenis Layanan
                    </label>

                    <select name="jenis_layanan"
                            class="form-select"
                            required>

                        <option value="Pengobatan">
                            Pengobatan
                        </option>

                        <option value="Vaksinasi">
                            Vaksinasi
                        </option>

                    </select>

                </div>


                {{-- JENIS PENYAKIT --}}
                <div class="mb-3">

                    <label class="form-label">
                        Jenis Penyakit
                    </label>

                    <input type="text"
                           name="jenis_penyakit"
                           class="form-control"
                           placeholder="Contoh: PMK, Parasit, Flu">

                </div>


                {{-- TANGGAL PELAYANAN --}}
                <div class="mb-3">

                    <label class="form-label">
                        Tanggal Pelayanan
                    </label>

                    <input type="date"
                           name="tanggal_pelayanan"
                           class="form-control"
                           value="{{ date('Y-m-d') }}"
                           required>

                </div>

            </div>


            {{-- FOOTER MODAL --}}
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
<!-- GRAFIK PENGOBATAN & VAKSINASI -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold text-success mb-1">
            📈 Tren Pengobatan & Vaksinasi per Bulan
        </h5>

        <small class="text-muted">
            Jumlah pelayanan berdasarkan tanggal pelayanan
        </small>
    </div>

    <div class="card-body">
        <div id="chartBulanan" style="min-height: 320px;"></div>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const dataBulanan = @json($dataBulanan ?? []);

    const bulan = [
        'Jan', 'Feb', 'Mar', 'Apr',
        'Mei', 'Jun', 'Jul', 'Agu',
        'Sep', 'Okt', 'Nov', 'Des'];

    const chartElement = document.querySelector("#chartBulanan");

    if (chartElement) {

        const chartBulanan = new ApexCharts(chartElement, {
            chart: {
                type: 'line',
                height: 320,
                toolbar: {
                    show: true
                }
            },

            series: [{
                name: 'Jumlah Pelayanan',
                data: dataBulanan
            }],

            xaxis: {
                categories: bulan,
                title: {
                    text: 'Bulan'
                }
            },

            yaxis: {
                min: 0,
                forceNiceScale: true,
                title: {
                    text: 'Jumlah Pelayanan'
                }
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            markers: {
                size: 5
            },

            dataLabels: {
                enabled: true
            },

            tooltip: {
                y: {
                    formatter: function (value) {
                        return value + ' pelayanan';
                    }
                }
            }
        });

        chartBulanan.render();
    }
});
</script>
@endsection
