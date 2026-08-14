<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // CEK TABEL YANG DIPERLUKAN
        // =====================================================

        $hasPopulasi = Schema::hasTable('populasi_ternaks');
        $hasIb = Schema::hasTable('inseminasi_buatans');
        $hasSkkh = Schema::hasTable('skkhs');
        $hasPengobatan = Schema::hasTable('pengobatans');
        $hasSkup = Schema::hasTable('surat_keterangan_usahas');

        // =====================================================
        // 1. STAT CARD
        // =====================================================

        $totalPopulasi = $hasPopulasi
            ? DB::table('populasi_ternaks')->count()
            : 0;

        $totalSkkh = $hasSkkh
            ? DB::table('skkhs')->count()
            : 0;

        $totalIb = $hasIb
            ? DB::table('inseminasi_buatans')->count()
            : 0;

        $totalPengobatan = $hasPengobatan
            ? DB::table('pengobatans')->count()
            : 0;

        $totalNkv = Schema::hasTable('nkvs')
            ? DB::table('nkvs')->count()
            : 0;

        $totalSertifikasi = Schema::hasTable('sertifikasis')
            ? DB::table('sertifikasis')->count()
            : 0;


        // =====================================================
        // 2. GRAFIK POPULASI TERNAK
        // =====================================================

        $jenisPopulasiList = [
            'Sapi',
            'Kambing',
            'Domba',
            'Kerbau',
            'Ayam',
            'Bebek',
            'Itik'
        ];

        $dataPopulasi = array_fill(0, count($jenisPopulasiList), 0);

        if ($hasPopulasi) {

            $populasi = DB::table('populasi_ternaks')
                ->select(
                    DB::raw('LOWER(jenis_ternak) as jenis'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy(DB::raw('LOWER(jenis_ternak)'))
                ->get();

            foreach ($populasi as $item) {

                foreach ($jenisPopulasiList as $index => $jenis) {

                    if (stripos($item->jenis, strtolower($jenis)) !== false) {
                        $dataPopulasi[$index] += (int) $item->total;
                    }
                }
            }
        }


        // =====================================================
        // 3. GRAFIK INSEMINASI BUATAN
        // =====================================================

        $jenisIbList = [
            'Sapi',
            'Kambing',
            'Domba',
            'Kerbau'
        ];

        $dataIb = array_fill(0, count($jenisIbList), 0);

        if ($hasIb) {

            $ib = DB::table('inseminasi_buatans')
                ->select(
                    DB::raw('LOWER(jenis_hewan) as jenis'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy(DB::raw('LOWER(jenis_hewan)'))
                ->get();

            foreach ($ib as $item) {

                foreach ($jenisIbList as $index => $jenis) {

                    if (stripos($item->jenis, strtolower($jenis)) !== false) {
                        $dataIb[$index] += (int) $item->total;
                    }
                }
            }
        }


        // =====================================================
        // 4. GRAFIK SKKH PER BULAN
        // =====================================================

        $dataSkkh = array_fill(0, 12, 0);

        if ($hasSkkh) {

            $skkhBulanan = DB::table('skkhs')
                ->select(
                    DB::raw('EXTRACT(MONTH FROM created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->get();

            foreach ($skkhBulanan as $item) {
                $dataSkkh[(int) $item->bulan - 1] = (int) $item->total;
            }
        }


        // =====================================================
        // 5. GRAFIK PENYAKIT TERBANYAK
        // =====================================================

        $dataPenyakit = [];
        $labelPenyakit = [];

        if ($hasPengobatan) {

            $penyakit = DB::table('pengobatans')
                ->select(
                    'jenis_penyakit',
                    DB::raw('COUNT(*) as total')
                )
                ->where('jenis_layanan', 'Pengobatan')
                ->whereNotNull('jenis_penyakit')
                ->where('jenis_penyakit', '!=', '')
                ->groupBy('jenis_penyakit')
                ->orderByDesc('total')
                ->get();

            foreach ($penyakit as $item) {

                $labelPenyakit[] = $item->jenis_penyakit;
                $dataPenyakit[] = (int) $item->total;
            }
        }


        // =====================================================
        // 6. GRAFIK SKUP
        // =====================================================

        $dataSkup = [];
        $labelSkup = [];

        if ($hasSkup) {

            $skup = DB::table('surat_keterangan_usahas')
                ->select(
                    'jenis_komoditi_usaha',
                    DB::raw('COUNT(*) as total')
                )
                ->whereNotNull('jenis_komoditi_usaha')
                ->where('jenis_komoditi_usaha', '!=', '')
                ->groupBy('jenis_komoditi_usaha')
                ->orderByDesc('total')
                ->get();

            foreach ($skup as $item) {

                $labelSkup[] = $item->jenis_komoditi_usaha;
                $dataSkup[] = (int) $item->total;
            }
        }


        // =====================================================
        // KIRIM DATA KE DASHBOARD
        // =====================================================

        return view('dashboard', compact(
            'totalPopulasi',
            'totalSkkh',
            'totalIb',
            'totalPengobatan',
            'totalNkv',
            'totalSertifikasi',
            'dataPopulasi',
            'dataIb',
            'dataSkkh',
            'dataSkup',
            'labelSkup',
            'dataPenyakit',
            'labelPenyakit'
        ));
    }
}