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
        // 2. Deteksi nama tabel Inseminasi Buatan
        $ibTable = null;
        $possibleIbTables = ['inseminasi_buatans', 'inseminasis', 'inseminasi_buatan', 'inseminasi'];
        foreach ($possibleIbTables as $tbl) {
            if (Schema::hasTable($tbl)) {
                $ibTable = $tbl;
                break;
            }
        }
        // 3. Hitung Stat Cards
        $totalPopulasi    = $populasiTable ? DB::table($populasiTable)->count() : 0;

        $totalSkkh        = Schema::hasTable('skkhs') ? DB::table('skkhs')->count() : 0;

        $totalIb          = $ibTable ? DB::table($ibTable)->count() : 0;

        $totalPengobatan  = Schema::hasTable('pengobatans') ? DB::table('pengobatans')->count() : 0;

        $totalNkv         = Schema::hasTable('nkvs') ? DB::table('nkvs')->count() : 0;

        $totalSertifikasi = Schema::hasTable('sertifikasis') ? DB::table('sertifikasis')->count() : 0;
        // 4. Data Grafik Populasi Ternak (Ditambahkan Ayam, Bebek, Itik)
        $dataPopulasi = [0, 0, 0, 0, 0, 0, 0];
if ($populasiTable) {
            $jenisPopulasiList = ['Sapi', 'Kambing', 'Domba', 'Kerbau', 'Ayam', 'Bebek', 'Itik'];
            foreach ($jenisPopulasiList as $index => $jenis) {
                $dataPopulasi[$index] = DB::table($populasiTable)
                    ->where(function($q) use ($jenis) {
                        $q->where('jenis_ternak', 'ILIKE', "%{$jenis}%")
                          ->orWhere('jenis_ternak', 'LIKE', "%{$jenis}%");
                    })
                    ->count();
            }
        }
        // 5. Data Grafik Inseminasi Buatan (Sapi, Kambing, Domba, Kerbau)
        $dataIb = [0, 0, 0, 0];
        if ($ibTable) {
            $jenisIbList = ['Sapi', 'Kambing', 'Domba', 'Kerbau'];
            foreach ($jenisIbList as $index => $jenis) {
                $dataIb[$index] = DB::table($ibTable)
                    ->where(function($q) use ($jenis) {
                        $q->where('jenis_hewan', 'ILIKE', "%{$jenis}%")
                          ->orWhere('jenis_hewan', 'LIKE', "%{$jenis}%");
                    })
                    ->count();
            }
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

