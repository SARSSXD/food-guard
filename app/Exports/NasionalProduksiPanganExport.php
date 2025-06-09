<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class NasionalProduksiPanganExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'Komoditas' => $item->komoditas,
                'Jumlah' => $item->jumlah,
                'Periode' => $item->periode,
                'Provinsi' => $item->region->provinsi,
                'Status Validasi' => $item->status_valid,
                'Dibuat Oleh' => $item->creator->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Komoditas',
            'Jumlah (Ton)',
            'Periode',
            'Provinsi',
            'Status Validasi',
            'Dibuat Oleh',
        ];
    }
}
