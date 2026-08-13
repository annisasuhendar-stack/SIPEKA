<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganUsaha extends Model
{
    protected $fillable = [
        'nomor_surat',
        'identitas_pemilik',
        'jenis_komoditi_usaha',
        'dokumen',
    ];
}