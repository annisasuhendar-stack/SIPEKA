<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InseminasiBuatan extends Model
{
    protected $fillable = [
        'jenis_hewan',
        'identitas_pemilik',
        'alamat',
    ];
}