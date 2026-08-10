<?php

namespace App\Exports;

use App\Models\Pengobatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengobatanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pengobatan::select('id', 'nama_pemilik', 'jenis_hewan', 'jenis_layanan', 'jenis_penyakit', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Pemilik', 'Jenis Hewan/Ternak', 'Jenis Layanan', 'Jenis Penyakit', 'Tanggal Input'];
    }
}