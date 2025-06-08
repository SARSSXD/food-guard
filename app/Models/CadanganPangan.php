<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CadanganPangan
 *
 * Represents food stock data in the food security system.
 *
 * @property int $id
 * @property string $komoditas
 * @property float $jumlah
 * @property int $id_lokasi
 * @property string $status_valid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class CadanganPangan extends Model
{
    use HasFactory;

    protected $table = 'cadangan_pangan';

    protected $fillable = [
        'komoditas',
        'jumlah',
        'id_lokasi',
        'status_valid',
    ];

    /**
     * Get the region associated with this food stock data.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }
}
