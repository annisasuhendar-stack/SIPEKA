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

    // =====================================================
    // DATA TABEL + SEARCH + PAGINATION
    // =====================================================

    $pengobatans = Pengobatan::when($search, function ($query, $search) {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_pemilik', 'ILIKE', "%{$search}%")
              ->orWhere('jenis_hewan', 'ILIKE', "%{$search}%")
              ->orWhere('jenis_penyakit', 'ILIKE', "%{$search}%");
        });
    })
    ->latest()
    ->paginate(10);


    // =====================================================
    // GRAFIK PENYAKIT PER BULAN
    // HANYA 1 QUERY
    // =====================================================

    $penyakitBulanan = Pengobatan::whereNotNull('jenis_penyakit')
        ->where('jenis_penyakit', '!=', '')
        ->select(
            'jenis_penyakit',
            DB::raw('EXTRACT(MONTH FROM tanggal_pelayanan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(
            'jenis_penyakit',
            DB::raw('EXTRACT(MONTH FROM tanggal_pelayanan)')
        )
        ->orderBy('jenis_penyakit')
        ->get();


    $dataPenyakit = [];

    foreach ($penyakitBulanan->groupBy('jenis_penyakit') as $penyakit => $items) {

        $data = array_fill(0, 12, 0);

        foreach ($items as $item) {
            $data[(int) $item->bulan - 1] = (int) $item->total;
        }

        $dataPenyakit[] = [
            'name' => $penyakit,
            'data' => $data
        ];
    }


    // =====================================================
    // PENYAKIT PALING BANYAK DITEMUKAN
    // =====================================================

    $penyakitTerbanyak = Pengobatan::whereNotNull('jenis_penyakit')
        ->where('jenis_penyakit', '!=', '')
        ->select('jenis_penyakit')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('jenis_penyakit')
        ->orderByDesc('total')
        ->first();


    // =====================================================
    // KASUS PER BULAN
    // HANYA 1 QUERY
    // =====================================================

    $kasusBulanan = Pengobatan::whereNotNull('jenis_penyakit')
        ->where('jenis_penyakit', '!=', '')
        ->select(
            DB::raw('EXTRACT(MONTH FROM tanggal_pelayanan) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(
            DB::raw('EXTRACT(MONTH FROM tanggal_pelayanan)')
        )
        ->get();

    $kasusPerBulan = array_fill(1, 12, 0);

    foreach ($kasusBulanan as $item) {
        $kasusPerBulan[(int) $item->bulan] = (int) $item->total;
    }


    $bulanTerbanyak = !empty($kasusPerBulan)
        ? array_search(max($kasusPerBulan), $kasusPerBulan)
        : null;


    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $namaBulanTerbanyak = $bulanTerbanyak
        ? $namaBulan[$bulanTerbanyak]
        : '-';

    $jumlahKasusBulanTerbanyak = $bulanTerbanyak
        ? $kasusPerBulan[$bulanTerbanyak]
        : 0;


    // =====================================================
    // PENYAKIT BERDASARKAN JENIS HEWAN
    // HANYA 1 QUERY
    // =====================================================

    $hewanData = Pengobatan::whereNotNull('jenis_hewan')
        ->where('jenis_hewan', '!=', '')
        ->whereNotNull('jenis_penyakit')
        ->where('jenis_penyakit', '!=', '')
        ->select(
            'jenis_hewan',
            'jenis_penyakit'
        )
        ->selectRaw('COUNT(*) as total')
        ->groupBy(
            'jenis_hewan',
            'jenis_penyakit'
        )
        ->orderByDesc('total')
        ->get();


    $labelHewan = [];
    $dataHewan = [];

    foreach ($hewanData as $item) {

        $labelHewan[] =
            $item->jenis_hewan . ' - ' . $item->jenis_penyakit;

        $dataHewan[] = (int) $item->total;
    }


    // =====================================================
    // HEWAN DENGAN KASUS TERBANYAK
    // HANYA 1 QUERY
    // =====================================================

    $hewanDataTotal = Pengobatan::whereNotNull('jenis_hewan')
        ->where('jenis_hewan', '!=', '')
        ->select(
            'jenis_hewan'
        )
        ->selectRaw('COUNT(*) as total')
        ->groupBy('jenis_hewan')
        ->orderByDesc('total')
        ->get();


    if ($hewanDataTotal->isNotEmpty()) {

        $jumlahTerbanyak = $hewanDataTotal->first()->total;

        $hewanTerbanyak = $hewanDataTotal
            ->where('total', $jumlahTerbanyak)
            ->pluck('jenis_hewan')
            ->implode(' & ');

    } else {

        $hewanTerbanyak = '-';
    }


    // =====================================================
    // KIRIM KE VIEW
    // =====================================================

    return view('pengobatan.index', compact(
        'pengobatans',
        'dataPenyakit',
        'penyakitTerbanyak',
        'namaBulanTerbanyak',
        'jumlahKasusBulanTerbanyak',
        'labelHewan',
        'dataHewan',
        'hewanTerbanyak'
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