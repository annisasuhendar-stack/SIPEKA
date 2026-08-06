<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopulasiTernak extends Model
{
    protected $fillable = [
        'kecamatan_id',
        'desa_id',
        'jenis_ternak',
        'jumlah',
        'tahun'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}