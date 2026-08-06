<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\PopulasiTernak;
use Illuminate\Http\Request;

class PopulasiTernakController extends Controller
{
    public function index()
    {
        $data = PopulasiTernak::with(['kecamatan', 'desa'])
                    ->latest()
                    ->get();

        return view('populasi.index', compact('data'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        // $desas dikosongkan saat render awal agar dropdown desa menunggu kecamatan dipilih
        $desas = collect(); 

        return view('populasi.create', compact('kecamatans', 'desas'));
    }

    // Method baru untuk AJAX Dependent Dropdown
    public function getDesa($kecamatan_id)
    {
        $desas = Desa::where('kecamatan_id', $kecamatan_id)
                    ->orderBy('nama_desa')
                    ->get();

        return response()->json($desas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'jenis_ternak' => 'required',
            'jumlah' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        PopulasiTernak::create($request->all());

        return redirect()->route('populasi.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $populasi = PopulasiTernak::findOrFail($id);
        $populasi->delete();

        return redirect()->route('populasi.index')
            ->with('success', 'Data populasi berhasil dihapus!');
    }
}