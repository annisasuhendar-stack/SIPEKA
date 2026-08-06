<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\PopulasiTernak;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $totalLayanan = Layanan::count();

        // Jumlah seluruh populasi ternak
        $totalPopulasi = PopulasiTernak::sum('jumlah');
$totalKecamatan = Kecamatan::count();

$totalDesa = Desa::count();
$grafikPopulasi = DB::table('populasi_ternaks')
    ->join('kecamatans', 'populasi_ternaks.kecamatan_id', '=', 'kecamatans.id')
    ->select(
        'kecamatans.nama_kecamatan',
        DB::raw('SUM(populasi_ternaks.jumlah) as total')
    )
    ->groupBy('kecamatans.nama_kecamatan')
    ->orderBy('total', 'desc')
    ->get();
        return view('dashboard', compact(
    'totalLayanan',
    'totalPopulasi',
    'totalKecamatan',
    'totalDesa',
    'grafikPopulasi'
));
    }
}