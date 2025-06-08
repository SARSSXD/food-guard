<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArtikelGizi
 *
 * Represents nutrition articles in the food security system.
 *
 * @property int $id
 * @property string $judul
 * @property string $isi
 * @property string $kategori
 * @property int $id_penulis
 * @property int $jumlah_akses
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ArtikelGizi extends Model
{
    use HasFactory;

    protected $table = 'artikel_gizi';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'id_penulis',
        'jumlah_akses',
    ];

    /**
     * Get the author of this nutrition article.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'id_penulis');
    }
}
