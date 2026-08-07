<?php

namespace App\Http\Controllers;

use App\Models\PopulasiTernak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Deteksi nama tabel populasi ternak
        $populasiTable = Schema::hasTable('populasi_ternaks') ? 'populasi_ternaks' : (Schema::hasTable('populasis') ? 'populasis' : null);

        // 1. Ambil Total Data untuk Stat Cards
        $totalPopulasi = $populasiTable ? (int) DB::table($populasiTable)->sum('jumlah') : 0;
        $totalSkkh     = Schema::hasTable('skkhs') ? DB::table('skkhs')->count() : 0;
        $totalIb       = Schema::hasTable('inseminasis') ? DB::table('inseminasis')->count() : 0;
        $totalPengobatan = Schema::hasTable('pengobatans') ? DB::table('pengobatans')->count() : 0;
        $totalNkv      = Schema::hasTable('nkvs') ? DB::table('nkvs')->count() : 0;
        $totalSertifikasi = Schema::hasTable('sertifikasis') ? DB::table('sertifikasis')->count() : 0;

        // 2. Data Grafik Populasi Ternak (SUM berdasarkan kolom jumlah & jenis_ternak)
        $dataPopulasi = [0, 0, 0, 0];
        if ($populasiTable) {
            $jenisList = ['Sapi', 'Kambing', 'Domba', 'Kerbau'];
            
            foreach ($jenisList as $index => $jenis) {
                $dataPopulasi[$index] = (int) DB::table($populasiTable)
                    ->where('jenis_ternak', $jenis)
                    ->sum('jumlah');
            }
        }

        // 3. Data Grafik SKKH per Bulan (Januari - Juni)
        $dataSkkh = [0, 0, 0, 0, 0, 0];
        if (Schema::hasTable('skkhs')) {
            $dataSkkh = [
                DB::table('skkhs')->whereMonth('created_at', 1)->count(),
                DB::table('skkhs')->whereMonth('created_at', 2)->count(),
                DB::table('skkhs')->whereMonth('created_at', 3)->count(),
                DB::table('skkhs')->whereMonth('created_at', 4)->count(),
                DB::table('skkhs')->whereMonth('created_at', 5)->count(),
                DB::table('skkhs')->whereMonth('created_at', 6)->count(),
            ];
        }

        // Kirim data ke View
        return view('dashboard', compact(
            'totalPopulasi',
            'totalSkkh',
            'totalIb',
            'totalPengobatan',
            'totalNkv',
            'totalSertifikasi',
            'dataPopulasi',
            'dataSkkh'
        ));
    }
}