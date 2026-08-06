<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PopulasiTernaksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('populasi_ternaks')->delete();
        
        \DB::table('populasi_ternaks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kecamatan_id' => 1,
                'desa_id' => 7,
                'jenis_ternak' => 'Domba',
                'jumlah' => 10,
                'tahun' => '2026',
                'created_at' => '2026-08-06 04:07:25',
                'updated_at' => '2026-08-06 04:07:25',
            ),
            1 => 
            array (
                'id' => 2,
                'kecamatan_id' => 6,
                'desa_id' => 57,
                'jenis_ternak' => 'Domba',
                'jumlah' => 15,
                'tahun' => '2026',
                'created_at' => '2026-08-06 04:07:46',
                'updated_at' => '2026-08-06 04:07:46',
            ),
            2 => 
            array (
                'id' => 3,
                'kecamatan_id' => 13,
                'desa_id' => 132,
                'jenis_ternak' => 'Kambing',
                'jumlah' => 25,
                'tahun' => '2026',
                'created_at' => '2026-08-06 04:08:09',
                'updated_at' => '2026-08-06 04:08:09',
            ),
        ));
        
        
    }
}