<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NasionalDistribusiPanganExport implements FromCollection, WithHeadings
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
                'Komoditas' => $item->komoditas,
                'Jumlah (Ton)' => number_format($item->jumlah, 2),
                'Tanggal Kirim' => \Carbon\Carbon::parse($item->tanggal_kirim)->format('d-m-Y'),
                'Status' => ucfirst($item->status),
                'Provinsi Tujuan' => $item->region->provinsi . ' - ' . $item->region->kota,
                'Dibuat Oleh' => $item->creator->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Komoditas',
            'Jumlah (Ton)',
            'Tanggal Kirim',
            'Status',
            'Provinsi Tujuan',
            'Dibuat Oleh',
        ];
    }
}
