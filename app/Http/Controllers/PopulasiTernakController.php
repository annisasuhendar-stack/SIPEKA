<?php

namespace App\Http\Controllers;

use App\Models\PopulasiTernak;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;       
use Illuminate\Database\Schema\Blueprint;
class PopulasiTernakController extends Controller
{
    public function index()
    {
        // Otomatis buat kolom 'bulan' di database jika belum ada
        if (!Schema::hasColumn('populasi_ternaks', 'bulan')) {
            Schema::table('populasi_ternaks', function (Blueprint $table) {
                $table->string('bulan')->nullable()->after('jumlah');
            });
        }

        $data = PopulasiTernak::with(['kecamatan', 'desa'])
            ->latest()
            ->get();

        return view('populasi.index', compact('data'));
    }
    public function create()
    {
        $kecamatans = Kecamatan::all();
        return view('populasi.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'desa_id'      => 'required',
            'jenis_ternak' => 'required',
            'jumlah'       => 'required|numeric',
            'bulan'        => 'required',
            'tahun'        => 'required',
        ]);

        PopulasiTernak::create($request->all());

        return redirect()->route('populasi.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $populasi = PopulasiTernak::findOrFail($id);
        $kecamatan = Kecamatan::all();
        $desa = Desa::where('kecamatan_id', $populasi->kecamatan_id)->get();

        return view('populasi.edit', compact('populasi', 'kecamatan', 'desa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'desa_id'      => 'required',
            'jenis_ternak' => 'required',
            'jumlah'       => 'required|numeric',
            'tahun'        => 'required',
        ]);

        $populasi = PopulasiTernak::findOrFail($id);
        $populasi->update($request->all());

        return redirect()->route('populasi.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $populasi = PopulasiTernak::findOrFail($id);
        $populasi->delete();

        return redirect()->route('populasi.index')->with('success', 'Data berhasil dihapus!');
    }

    // Dynamic Dropdown Desa saat ubah Kecamatan
    public function getDesa($kecamatan_id)
    {
        $desa = Desa::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($desa);
    }

    // Export CSV Berkolom Rapi (Pemisah Titik Koma ';' untuk Excel Regional Indonesia)
    public function export()
    {
        $filename = "data_populasi_ternak_" . date('Y-m-d') . ".csv";
        $data = PopulasiTernak::with(['kecamatan', 'desa'])->get();

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function() use($data) {
            if (ob_get_level()) {
                ob_end_clean();
            }

            $file = fopen('php://output', 'w');

            // Header BOM UTF-8 agar Excel membaca karakter dengan benar
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Judul Kolom (Memakai ';' sebagai pemisah kolom Excel Indonesia)
            fputcsv($file, ['No', 'Kecamatan', 'Desa', 'Jenis Ternak', 'Jumlah', 'Tahun'], ';');

            // Baris Data
            foreach ($data as $key => $row) {
                fputcsv($file, [
                    $key + 1,
                    $row->kecamatan->nama_kecamatan ?? '-',
                    $row->desa->nama_desa ?? '-',
                    $row->jenis_ternak,
                    $row->jumlah,
                    $row->tahun
                ], ';');
            }

            fclose($file);
        }, 200, $headers);
    }
}