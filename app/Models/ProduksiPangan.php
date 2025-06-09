<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiPangan extends Model
{
    use HasFactory;

    protected $table = 'produksi_pangan';

    protected $fillable = [
        'komoditas',
        'jumlah',
        'periode',
        'id_lokasi',
        'status_valid',
        'created_by',
    ];

    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}