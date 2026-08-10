@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Populasi Ternak</h2>

    <form action="{{ route('populasi.update', $populasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kecamatan_id" class="form-label">Kecamatan</label>
            <select name="kecamatan_id" id="kecamatan_id" class="form-control" required>
                <option value="">-- Pilih Kecamatan --</option>
                @foreach($kecamatan as $k)
                    <option value="{{ $k->id }}" {{ $populasi->kecamatan_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kecamatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="desa_id" class="form-label">Desa</label>
            <select name="desa_id" id="desa_id" class="form-control" required>
                <option value="">-- Pilih Desa --</option>
                @foreach($desa as $d)
                    <option value="{{ $d->id }}" {{ $populasi->desa_id == $d->id ? 'selected' : '' }}>
                        {{ $d->nama_desa }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_ternak" class="form-label">Jenis Ternak</label>
            <input type="text" name="jenis_ternak" class="form-control" value="{{ $populasi->jenis_ternak }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $populasi->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ $populasi->tahun }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('populasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- Script untuk Dynamic Dropdown Desa saat Kecamatan diubah --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#kecamatan_id').on('change', function() {
        var kecamatanID = $(this).val();
        if(kecamatanID) {
            $.ajax({
                url: '/get-desa/' + kecamatanID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#desa_id').empty();
                    $('#desa_id').append('<option value="">-- Pilih Desa --</option>');
                    $.each(data, function(key, value) {
                        $('#desa_id').append('<option value="'+ value.id +'">'+ value.nama_desa +'</option>');
                    });
                }
            });
        } else {
            $('#desa_id').empty();
        }
    });
</script>
@endsection