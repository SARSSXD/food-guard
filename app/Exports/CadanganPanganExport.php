<?php

namespace App\Exports;

use App\Models\CadanganPangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadanganPanganExport implements FromCollection, WithHeadings
{
    protected $kota;

    public function __construct($kota = null)
    {
        $this->kota = $kota;
    }

    public function collection()
    {
        $query = CadanganPangan::where('status_valid', 'terverifikasi')
            ->with('region')
            ->select('komoditas', 'jumlah', 'periode', 'status_valid', 'id_lokasi');

        if ($this->kota) {
            $query->whereHas('region', function ($q) {
                $q->where('kota', $this->kota);
            });
        }

        return $query->get()->map(function ($item) {
            return [
                'Komoditas' => $item->komoditas,
                'Jumlah (Ton)' => $item->jumlah,
                'Periode' => $item->periode,
                'Kota' => $item->region->kota,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Komoditas',
            'Jumlah (Ton)',
            'Periode',
            'Kota',
        ];
    }
}
