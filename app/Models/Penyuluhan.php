<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyuluhan extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_penyuluhan';
    protected $fillable = [
        'judul',
        'jenis',
        'tanggal',
        'Id_lokasi',
        'kuota',
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

    public function peserta()
    {
        return $this->hasMany(PenyuluhanPeserta::class, 'Id_penyuluhan', 'Id_penyuluhan');
    }
}