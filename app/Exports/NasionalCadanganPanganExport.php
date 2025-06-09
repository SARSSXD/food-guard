<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NasionalCadanganPanganExport implements FromCollection, WithHeadings
{
    protected $cadanganPangan;

    public function __construct($cadanganPangan)
    {
        $this->cadanganPangan = $cadanganPangan;
    }

    public function collection()
    {
        return $this->cadanganPangan->map(function ($item) {
            return [
                'Komoditas' => $item->komoditas,
                'Jumlah (Ton)' => $item->jumlah,
                'Tahun' => $item->periode,
                'Provinsi' => $item->region->provinsi,
                'Status Validasi' => $item->status_valid,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Komoditas',
            'Jumlah (Ton)',
            'Tahun',
            'Provinsi',
            'Status Validasi',
        ];
    }
}
