<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_layanan' => 'NKV'],
            ['nama_layanan' => 'GBP'],
            ['nama_layanan' => 'SKKH'],
            ['nama_layanan' => 'Inseminasi Buatan'],
            ['nama_layanan' => 'Surat Keterangan Peternakan'],
            ['nama_layanan' => 'GFP'],
        ];

        foreach ($data as $item) {
            Layanan::create($item);
        }
    }
}