<?php

namespace App\Exports;

use App\Models\PopulasiTernak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PopulasiTernakExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PopulasiTernak::with(['kecamatan', 'desa'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kecamatan',
            'Desa',
            'Jenis Ternak',
            'Jumlah',
            'Tahun'
        ];
    }

    public function map($row): array
    {
        static $no = 1;
        return [
            $no++,
            $row->kecamatan->nama_kecamatan ?? '-',
            $row->desa->nama_desa ?? '-',
            $row->jenis_ternak ?? '-',
            $row->jumlah ?? 0,
            $row->tahun ?? '-'
        ];
    }
}