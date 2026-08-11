<?php

namespace App\Http\Controllers;

use App\Models\Pengobatan;
use Illuminate\Http\Request;
use App\Exports\PengobatanExport;
use Maatwebsite\Excel\Facades\Excel;

class PengobatanController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $pengobatans = Pengobatan::when($search, function ($query, $search) {
        return $query->where('nama_pemilik', 'ILIKE', "%{$search}%")
                     ->orWhere('jenis_hewan', 'ILIKE', "%{$search}%")
                     ->orWhere('jenis_penyakit', 'ILIKE', "%{$search}%");})->latest()->paginate(10);
// DATA GRAFIK PENGOBATAN & VAKSINASI PER BULAN
    $dataBulanan = [];
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $dataBulanan[] = Pengobatan::whereMonth('tanggal_pelayanan', $bulan)
            ->count(); }
    return view('pengobatan.index', compact(
        'pengobatans',
        'dataBulanan'
    ));
}
    public function store(Request $request)
{
    $request->validate([
        'nama_pemilik'      => 'required|string|max:255',
        'jenis_hewan'       => 'required|string|max:255',
        'jenis_layanan'     => 'required|in:Vaksinasi,Pengobatan',
        'jenis_penyakit'    => 'nullable|string|max:255',
        'tanggal_pelayanan' => 'required|date',
    ]);

    Pengobatan::create($request->all());

    return redirect()
        ->route('pengobatan.index')
        ->with('success', 'Data pengobatan/vaksinasi berhasil ditambahkan!');
}

   public function update(Request $request, $id)
{
    $request->validate([
        'nama_pemilik'      => 'required|string|max:255',
        'jenis_hewan'       => 'required|string|max:255',
        'jenis_layanan'     => 'required|in:Vaksinasi,Pengobatan',
        'jenis_penyakit'    => 'nullable|string|max:255',
        'tanggal_pelayanan' => 'required|date',
    ]);

    $pengobatan = Pengobatan::findOrFail($id);

    $pengobatan->update($request->all());

    return redirect()
        ->route('pengobatan.index')
        ->with('success', 'Data pengobatan/vaksinasi berhasil diperbarui!');
}

    public function destroy($id)
    {
        $pengobatan = Pengobatan::findOrFail($id);
        $pengobatan->delete();

        return redirect()->route('pengobatan.index')->with('success', 'Data pengobatan/vaksinasi berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new PengobatanExport, 'data-pengobatan-vaksinasi.xlsx');
    }
}