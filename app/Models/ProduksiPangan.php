<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiPangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_produksipangan';
    protected $fillable = [
        'komoditas',
        'volume',
        'Id_lokasi',
        'waktu',
        'status_valid',
        'created_by',
    ];

    protected $casts = [
        'status_valid' => 'string',
        'waktu' => 'date',
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