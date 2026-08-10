@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Data Inseminasi Buatan</h2>
        <a href="{{ route('inseminasi.index') }}" class="btn btn-secondary">
            ⬅ Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inseminasi.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="jenis_hewan" class="form-label">Jenis Hewan</label>
                    <input type="text" name="jenis_hewan" id="jenis_hewan" class="form-control" value="{{ old('jenis_hewan', $data->jenis_hewan) }}" required>
                </div>

                <div class="mb-3">
                    <label for="identitas_pemilik" class="form-label">Identitas Pemilik</label>
                    <input type="text" name="identitas_pemilik" id="identitas_pemilik" class="form-control" value="{{ old('identitas_pemilik', $data->identitas_pemilik) }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $data->alamat) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    🔄 Perbarui Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection