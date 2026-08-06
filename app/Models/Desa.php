<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas'; // Mengarahkan ke nama tabel yang benar

    protected $fillable = [
        'kecamatan_id',
        'nama_desa'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}