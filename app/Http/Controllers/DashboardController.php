<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // =====================================================
            // 1. STAT CARDS (Menggunakan try-catch agar aman jika tabel kosong)
            // =====================================================
            $totalPopulasi    = DB::table('populasi_ternaks')->count();
            $totalSkkh        = DB::table('skkhs')->count();
            $totalIb          = DB::table('inseminasi_buatans')->count();
            $totalPengobatan  = DB::table('pengobatans')->count();
            $totalNkv         = DB::table('nkvs')->count();
            $totalSertifikasi = DB::table('sertifikasis')->count();
        } catch (Exception $e) {
            // Nilai 0 jika tabel belum dibuat/ada kendala
            $totalPopulasi = $totalSkkh = $totalIb = $totalPengobatan = $totalNkv = $totalSertifikasi = 0;
        }

        // =====================================================
        // 2. GRAFIK POPULASI TERNAK (Optimasi Query SQL)
        // =====================================================
        $jenisPopulasiList = ['Sapi', 'Kambing', 'Domba', 'Kerbau', 'Ayam', 'Bebek', 'Itik'];
        $dataPopulasi = array_fill(0, count($jenisPopulasiList), 0);

        try {
            $populasi = DB::table('populasi_ternaks')
                ->select('jenis_ternak', DB::raw('COUNT(*) as total'))
                ->groupBy('jenis_ternak')
                ->get();

            foreach ($populasi as $item) {
                foreach ($jenisPopulasiList as $index => $jenis) {
                    if (stripos($item->jenis_ternak, $jenis) !== false) {
                        $dataPopulasi[$index] += (int) $item->total;
                    }
                }
            }
        } catch (Exception $e) {
            // Lewati jika tabel belum ada
        }


        // =====================================================
        // 3. GRAFIK INSEMINASI BUATAN (IB)
        // =====================================================
        $jenisIbList = ['Sapi', 'Kambing', 'Domba', 'Kerbau'];
        $dataIb = array_fill(0, count($jenisIbList), 0);

        try {
            $ib = DB::table('inseminasi_buatans')
                ->select('jenis_hewan', DB::raw('COUNT(*) as total'))
                ->groupBy('jenis_hewan')
                ->get();

            foreach ($ib as $item) {
                foreach ($jenisIbList as $index => $jenis) {
                    if (stripos($item->jenis_hewan, $jenis) !== false) {
                        $dataIb[$index] += (int) $item->total;
                    }
                }
            }
        } catch (Exception $e) {
            // Lewati jika tabel belum ada
        }


        // =====================================================
        // 4. GRAFIK SKKH PER BULAN (Sudah Diperbaiki & Cepat)
        // =====================================================
        $dataSkkh = array_fill(0, 12, 0);

        try {
            $skkhBulanan = DB::table('skkhs')
                ->select(
                    DB::raw('EXTRACT(MONTH FROM created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->get();

            foreach ($skkhBulanan as $item) {
                $bulanIndex = ((int) $item->bulan) - 1;
                if ($bulanIndex >= 0 && $bulanIndex < 12) {
                    $dataSkkh[$bulanIndex] = (int) $item->total;
                }
            }
        } catch (Exception $e) {
            // Lewati jika tabel belum ada
        }


        // =====================================================
        // 5. GRAFIK PENYAKIT TERBANYAK
        // =====================================================
        $dataPenyakit = [];
        $labelPenyakit = [];

        try {
            $penyakit = DB::table('pengobatans')
                ->select('jenis_penyakit', DB::raw('COUNT(*) as total'))
                ->where('jenis_layanan', 'Pengobatan')
                ->whereNotNull('jenis_penyakit')
                ->where('jenis_penyakit', '!=', '')
                ->groupBy('jenis_penyakit')
                ->orderByDesc('total')
                ->limit(10) // Batasi 10 besar agar chart tidak terlalu penuh & berat
                ->get();

            foreach ($penyakit as $item) {
                $labelPenyakit[] = $item->jenis_penyakit;
                $dataPenyakit[]  = (int) $item->total;
            }
        } catch (Exception $e) {
            // Lewati jika tabel belum ada
        }


        // =====================================================
        // 6. GRAFIK SKUP
        // =====================================================
        $dataSkup = [];
        $labelSkup = [];

        try {
            $skup = DB::table('surat_keterangan_usahas')
                ->select('jenis_komoditi_usaha', DB::raw('COUNT(*) as total'))
                ->whereNotNull('jenis_komoditi_usaha')
                ->where('jenis_komoditi_usaha', '!=', '')
                ->groupBy('jenis_komoditi_usaha')
                ->orderByDesc('total')
                ->limit(10) // Batasi 10 besar
                ->get();

            foreach ($skup as $item) {
                $labelSkup[] = $item->jenis_komoditi_usaha;
                $dataSkup[]  = (int) $item->total;
            }
        } catch (Exception $e) {
            // Lewati jika tabel belum ada
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