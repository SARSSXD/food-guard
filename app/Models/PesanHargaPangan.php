<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanHargaPangan extends Model
{
    use HasFactory;

    protected $table = 'pesan_harga_pangan';
    protected $fillable = [
        'wilayah',
        'komoditas',
        'tahun',
        'pesan',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
