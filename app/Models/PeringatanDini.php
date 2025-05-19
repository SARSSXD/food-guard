<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeringatanDini extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_peringatan';
    protected $fillable = [
        'jenis',
        'Id_lokasi',
        'deskripsi',
        'tanggal',
        'status_respon',
        'tindakan',
    ];

    protected $casts = [
        'jenis' => 'string',
        'status_respon' => 'string',
        'tanggal' => 'date',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'Id_lokasi', 'Id_lokasi');
    }
}