<?php

namespace App\Exports;

use App\Models\InseminasiBuatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InseminasiBuatanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return InseminasiBuatan::select('id', 'jenis_hewan', 'identitas_pemilik', 'alamat', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jenis Hewan',
            'Identitas Pemilik',
            'Alamat',
            'Tanggal Dibuat',
        ];
    }
}