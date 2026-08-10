<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Deteksi nama tabel populasi
        $populasiTable = Schema::hasTable('populasi_ternaks') ? 'populasi_ternaks' : (Schema::hasTable('populasis') ? 'populasis' : null);

        // 2. Deteksi nama tabel Inseminasi Buatan (Cek berbagai kemungkinan nama tabel)
        $ibTable = null;
        $possibleIbTables = ['inseminasi_buatans', 'inseminasis', 'inseminasi_buatan', 'inseminasi'];
        foreach ($possibleIbTables as $tbl) {
            if (Schema::hasTable($tbl)) {
                $ibTable = $tbl;
                break;
            }
        }

        // 3. Hitung Stat Cards
        $totalPopulasi    = $populasiTable ? (int) DB::table($populasiTable)->sum('jumlah') : 0;
        $totalSkkh        = Schema::hasTable('skkhs') ? DB::table('skkhs')->count() : 0;
        $totalIb          = $ibTable ? DB::table($ibTable)->count() : 0;
        $totalPengobatan  = Schema::hasTable('pengobatans') ? DB::table('pengobatans')->count() : 0;
        $totalNkv         = Schema::hasTable('nkvs') ? DB::table('nkvs')->count() : 0;
        $totalSertifikasi = Schema::hasTable('sertifikasis') ? DB::table('sertifikasis')->count() : 0;

        // 4. Data Grafik Populasi Ternak
        $dataPopulasi = [0, 0, 0, 0];
        if ($populasiTable) {
            $jenisList = ['Sapi', 'Kambing', 'Domba', 'Kerbau'];
            foreach ($jenisList as $index => $jenis) {
                $dataPopulasi[$index] = (int) DB::table($populasiTable)
                    ->where('jenis_ternak', 'ILIKE', "%{$jenis}%")
                    ->orWhere('jenis_ternak', 'LIKE', "%{$jenis}%")
                    ->sum('jumlah');
            }
        }

        // 5. Data Grafik Inseminasi Buatan (IB)
$dataIb = [0, 0, 0]; // Order: [Sapi, Kambing, Domba/Lainnya]
if ($ibTable) {
    // Sapi: Menghitung semua data yang mengandung kata 'Sapi' (Sapi, Sapi Perah, Sapi Potong)
    $dataIb[0] = DB::table($ibTable)
        ->where('jenis_hewan', 'ILIKE', '%Sapi%')
        ->orWhere('jenis_hewan', 'LIKE', '%Sapi%')
        ->count();

    // Kambing: Menghitung semua data yang mengandung kata 'Kambing'
    $dataIb[1] = DB::table($ibTable)
        ->where('jenis_hewan', 'ILIKE', '%Kambing%')
        ->orWhere('jenis_hewan', 'LIKE', '%Kambing%')
        ->count();

    // Domba/Lainnya: Menghitung data yang mengandung kata 'Domba' atau 'Kerbau'
    $dataIb[2] = DB::table($ibTable)
        ->where('jenis_hewan', 'ILIKE', '%Domba%')
        ->orWhere('jenis_hewan', 'ILIKE', '%Kerbau%')
        ->orWhere('jenis_hewan', 'LIKE', '%Domba%')
        ->orWhere('jenis_hewan', 'LIKE', '%Kerbau%')
        ->count();
}

        // 6. Data Grafik SKKH per Bulan (Januari - Juni)
        $dataSkkh = [0, 0, 0, 0, 0, 0];
        if (Schema::hasTable('skkhs')) {
            for ($m = 1; $m <= 6; $m++) {
                $dataSkkh[$m - 1] = DB::table('skkhs')->whereMonth('created_at', $m)->count();
            }
        }

        return view('dashboard', compact(
            'totalPopulasi',
            'totalSkkh',
            'totalIb',
            'totalPengobatan',
            'totalNkv',
            'totalSertifikasi',
            'dataPopulasi',
            'dataIb',
            'dataSkkh'
        ));
    }
}