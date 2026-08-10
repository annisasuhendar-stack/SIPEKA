<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InseminasiBuatan extends Model
{
    // Tambahkan baris ini untuk menentukan nama tabel secara tegas
    protected $table = 'inseminasi_buatan';

    protected $fillable = [
        'jenis_hewan',
        'identitas_pemilik',
        'alamat',
    ];
}