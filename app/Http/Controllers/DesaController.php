<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index()
    {
        // Ambil data desa beserta relasi kecamatan, urutkan, dan rapikan index collection-nya
        $desas = Desa::with('kecamatan')
            ->get()
            ->sortBy([
                fn ($a, $b) => ($a->kecamatan->nama_kecamatan ?? '') <=> ($b->kecamatan->nama_kecamatan ?? ''),
                fn ($a, $b) => $a->nama_desa <=> $b->nama_desa,
            ])
            ->values();

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