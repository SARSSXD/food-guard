<?php

namespace App\Exports;

use App\Models\DistribusiPangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistribusiPanganExport implements FromCollection, WithHeadings
{
    protected $kota;
    protected $status;

    public function __construct($kota, $status)
    {
        $this->kota = $kota;
        $this->status = $status;
    }

    public function collection()
    {
        $query = DistribusiPangan::with('wilayah')
            ->select('komoditas', 'jumlah', 'tanggal_kirim', 'status', 'wilayah.kota');
        if ($this->kota) {
            $query->whereHas('wilayah', function ($q) {
                $q->where('kota', $this->kota);
            });
        }
        if ($this->status) {
            $query->where('status', $this->status);
        }
        return $query->get()->map(function ($item) {
            return [
                'Komoditas' => $item->komoditas,
                'Jumlah (Ton)' => $item->jumlah,
                'Tanggal Kirim' => $item->tanggal_kirim,
                'Status' => ucfirst($item->status),
                'Kota Tujuan' => $item->wilayah->kota,
            ];
        });
    }

    public function headings(): array
    {
        return ['Komoditas', 'Jumlah (Ton)', 'Tanggal Kirim', 'Status', 'Kota Tujuan'];
    }
}
