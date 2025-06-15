<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NasionalHargaPanganExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Provinsi' => $item->region->provinsi . ' - ' . $item->region->kota,
                'Komoditas' => $item->komoditas,
                'Harga/kg' => 'Rp ' . number_format($item->harga_per_kg, 0, ',', '.'),
                'Tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Provinsi',
            'Komoditas',
            'Harga/kg',
            'Tanggal',
        ];
    }
}
