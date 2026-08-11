<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skkh extends Model
{
    protected $table = 'skkhs';

    protected $fillable = [
        'nomor_surat',
        'nama_pemilik',
        'identitas_pemilik',
        'jenis_hewan',
        'tujuan_pengiriman',
        'dokumen',
    ];
}