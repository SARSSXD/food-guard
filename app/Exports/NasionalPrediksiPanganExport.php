<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NasionalPrediksiPanganExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'Jenis' => ucfirst($item->jenis),
                'Komoditas' => $item->komoditas,
                'Bulan-Tahun' => \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('F Y'),
                'Provinsi' => $item->region->provinsi,
                'Jumlah (Ton)' => number_format($item->jumlah, 2, ',', '.'),
                'Metode' => $item->metode,
                'Status' => ucfirst($item->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jenis',
            'Komoditas',
            'Bulan-Tahun',
            'Provinsi',
            'Jumlah (Ton)',
            'Metode',
            'Status',
        ];
    }
}
