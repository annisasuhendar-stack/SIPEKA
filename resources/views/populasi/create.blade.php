@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">
        <h4>Tambah Data Populasi Ternak</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('populasi.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Kecamatan</label>
                <select id="kecamatan" name="kecamatan_id" class="form-select" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}">
                            {{ $kecamatan->nama_kecamatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Desa</label>
                <select id="desa" name="desa_id" class="form-select" required>
                    <option value="">-- Pilih Desa --</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jenis Ternak</label>
                <select name="jenis_ternak" class="form-control" required>
                    <option value="">-- Pilih Jenis Ternak --</option>
                    <option>Sapi</option>
                    <option>Kerbau</option>
                    <option>Kambing</option>
                    <option>Domba</option>
                    <option>Ayam</option>
                    <option>Itik</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
<div class="mb-3">
    <label for="bulan" class="form-label">Bulan</label>
    <select name="bulan" id="bulan" class="form-control" required>
        <option value="">-- Pilih Bulan --</option>
        @php
            $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        @endphp
        @foreach($daftarBulan as $bln)
            <option value="{{ $bln }}" {{ (old('bulan', $data->bulan ?? '') == $bln) ? 'selected' : '' }}>
                {{ $bln }}
            </option>
        @endforeach
    </select>
</div>
            <div class="mb-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('populasi.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

<!-- Script Dynamic Dropdown -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#kecamatan').on('change', function() {
        var kecamatanId = $(this).val();
        var $desaSelect = $('#desa');

        // Reset dropdown desa
        $desaSelect.empty().append('<option value="">-- Pilih Desa --</option>');

        if (kecamatanId) {
            $.ajax({
                url: '/get-desa/' + kecamatanId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, desa) {
                        $desaSelect.append(
                            '<option value="' + desa.id + '">' + desa.nama_desa + '</option>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data desa:", error);
                }
            });
        }
    });
});
</script>

@endsection