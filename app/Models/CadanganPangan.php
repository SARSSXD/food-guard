<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadanganPangan extends Model
{
    use HasFactory;

    protected $table = 'cadangan_pangan';

    protected $fillable = [
        'komoditas',
        'jumlah',
        'periode',
        'id_lokasi',
        'status_valid',
    ];

    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }
}