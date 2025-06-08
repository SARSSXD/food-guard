<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HargaPangan
 *
 * Represents food price data in the food security system.
 *
 * @property int $id
 * @property string $nama_pasar
 * @property string $komoditas
 * @property float $harga_per_kg
 * @property int $id_lokasi
 * @property \Illuminate\Support\Carbon $tanggal
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class HargaPangan extends Model
{
    use HasFactory;

    protected $table = 'harga_pangan';

    protected $fillable = [
        'nama_pasar',
        'komoditas',
        'harga_per_kg',
        'id_lokasi',
        'tanggal',
        'created_by',
    ];

    protected $dates = ['tanggal'];

    /**
     * Get the region associated with this food price data.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    /**
     * Get the user who created this food price data.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
