<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengobatan extends Model
{
    use HasFactory;

    protected $fillable = [
    'nama_pemilik',
    'jenis_hewan',
    'jenis_layanan',
    'jenis_penyakit',
    'tanggal_pelayanan',
];
}