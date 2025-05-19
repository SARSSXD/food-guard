<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrediksiPangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_prediksipangan';
    protected $fillable = [
        'jenis',
        'komoditas',
        'Id_lokasi',
        'bulan_tahun',
        'volume',
        'metode',
        'status',
        'created_by',
    ];

    protected $casts = [
        'jenis' => 'string',
        'status' => 'string',
        'bulan_tahun' => 'date',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'Id_lokasi', 'Id_lokasi');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'Id_users');
    }
}