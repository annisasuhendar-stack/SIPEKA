<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index()
{
    // Mengurutkan berdasarkan nama kecamatan di tabel relasi, lalu nama desa
    $desas = Desa::with('kecamatan')
        ->join('kecamatans', 'desas.kecamatan_id', '=', 'kecamatans.id')
        ->orderBy('kecamatans.nama_kecamatan', 'asc') // Urutkan Kecamatan A-Z
        ->orderBy('desas.nama_desa', 'asc')           // Urutkan Desa A-Z dalam kecamatan yang sama
        ->select('desas.*')                            // Ambil hanya data dari tabel desas
        ->get(); // atau ->paginate(10) jika menggunakan pagination

    return view('desa.index', compact('desas'));
}
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();

        return view('desa.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'nama_desa' => 'required'
        ]);

        Desa::create($request->all());

        return redirect()->route('desa.index')
            ->with('success', 'Desa berhasil ditambahkan.');
    }

    // Method untuk mengambil desa berdasarkan kecamatan
    public function getDesa($kecamatanId)
    {
        $desa = Desa::where('kecamatan_id', $kecamatanId)
                    ->orderBy('nama_desa')
                    ->get();

        return response()->json($desa);
    }
}