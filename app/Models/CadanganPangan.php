<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadanganPangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_cadanganpangan';
    protected $fillable = [
        'komoditas',
        'volume',
        'Id_lokasi',
        'waktu',
        'status_valid',
    ];

    protected $casts = [
        'status_valid' => 'string',
        'waktu' => 'date',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'Id_lokasi', 'Id_lokasi');
    }
}