<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanPrediksiPangan extends Model
{
    use HasFactory;

    protected $table = 'pesan_prediksi_pangan';
    protected $fillable = [
        'provinsi',
        'komoditas',
        'bulan_tahun',
        'pesan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
