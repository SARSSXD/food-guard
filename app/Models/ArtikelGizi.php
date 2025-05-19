<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtikelGizi extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_artikelgizi';
    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'Id_penulis',
        'jumlah_akses',
        'created_at',
    ];

    protected $casts = [
        'kategori' => 'string',
        'created_at' => 'datetime',
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'Id_penulis', 'Id_users');
    }
}