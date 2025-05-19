<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_hargapangan';
    protected $fillable = [
        'nama_pasar',
        'komoditas',
        'harga_per_kg',
        'Id_lokasi',
        'tanggal',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
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