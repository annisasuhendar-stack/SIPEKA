<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = [
            ['kode_kecamatan' => 'K01', 'nama_kecamatan' => 'Angsana'],
            ['kode_kecamatan' => 'K02', 'nama_kecamatan' => 'Banjar'],
            ['kode_kecamatan' => 'K03', 'nama_kecamatan' => 'Bojong'],
            ['kode_kecamatan' => 'K04', 'nama_kecamatan' => 'Cadasari'],
            ['kode_kecamatan' => 'K05', 'nama_kecamatan' => 'Carita'],
            ['kode_kecamatan' => 'K06', 'nama_kecamatan' => 'Cibaliung'],
            ['kode_kecamatan' => 'K07', 'nama_kecamatan' => 'Cibitung'],
            ['kode_kecamatan' => 'K08', 'nama_kecamatan' => 'Cigeulis'],
            ['kode_kecamatan' => 'K09', 'nama_kecamatan' => 'Cikedal'],
            ['kode_kecamatan' => 'K10', 'nama_kecamatan' => 'Cikeusik'],
            ['kode_kecamatan' => 'K11', 'nama_kecamatan' => 'Cimanggu'],
            ['kode_kecamatan' => 'K12', 'nama_kecamatan' => 'Cimanuk'],
            ['kode_kecamatan' => 'K13', 'nama_kecamatan' => 'Cipeucang'],
            ['kode_kecamatan' => 'K14', 'nama_kecamatan' => 'Cisata'],
            ['kode_kecamatan' => 'K15', 'nama_kecamatan' => 'Jiput'],
            ['kode_kecamatan' => 'K16', 'nama_kecamatan' => 'Kaduhejo'],
            ['kode_kecamatan' => 'K17', 'nama_kecamatan' => 'Karang Tanjung'],
            ['kode_kecamatan' => 'K18', 'nama_kecamatan' => 'Koroncong'],
            ['kode_kecamatan' => 'K19', 'nama_kecamatan' => 'Labuan'],
            ['kode_kecamatan' => 'K20', 'nama_kecamatan' => 'Majasari'],
            ['kode_kecamatan' => 'K21', 'nama_kecamatan' => 'Mandalawangi'],
            ['kode_kecamatan' => 'K22', 'nama_kecamatan' => 'Menes'],
            ['kode_kecamatan' => 'K23', 'nama_kecamatan' => 'Munjul'],
            ['kode_kecamatan' => 'K24', 'nama_kecamatan' => 'Nagara'],
            ['kode_kecamatan' => 'K25', 'nama_kecamatan' => 'Pagelaran'],
            ['kode_kecamatan' => 'K26', 'nama_kecamatan' => 'Pandeglang'],
            ['kode_kecamatan' => 'K27', 'nama_kecamatan' => 'Panimbang'],
            ['kode_kecamatan' => 'K28', 'nama_kecamatan' => 'Patia'],
            ['kode_kecamatan' => 'K29', 'nama_kecamatan' => 'Picung'],
            ['kode_kecamatan' => 'K30', 'nama_kecamatan' => 'Pulosari'],
            ['kode_kecamatan' => 'K31', 'nama_kecamatan' => 'Saketi'],
            ['kode_kecamatan' => 'K32', 'nama_kecamatan' => 'Sindangresmi'],
            ['kode_kecamatan' => 'K33', 'nama_kecamatan' => 'Sobang'],
            ['kode_kecamatan' => 'K34', 'nama_kecamatan' => 'Sukaresmi'],
            ['kode_kecamatan' => 'K35', 'nama_kecamatan' => 'Sumur'],
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::create($kecamatan);
        }
    }
}