<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiPangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_distribusipangan';
    protected $fillable = [
        'wilayah_tujuan',
        'komoditas',
        'volume',
        'tanggal_kirim',
        'status',
        'rute',
        'created_by',
    ];

    protected $casts = [
        'status' => 'string',
        'tanggal_kirim' => 'date',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Lokasi::class, 'wilayah_tujuan', 'Id_lokasi');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'Id_users');
    }
}