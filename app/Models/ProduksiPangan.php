<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProduksiPangan
 *
 * Represents food production data in the food security system.
 *
 * @property int $id
 * @property string $komoditas
 * @property float $jumlah
 * @property int $id_lokasi
 * @property string $status_valid
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ProduksiPangan extends Model
{
    use HasFactory;

    protected $table = 'produksi_pangan';

    protected $fillable = [
        'komoditas',
        'jumlah',
        'id_lokasi',
        'status_valid',
        'created_by',
    ];

    /**
     * Get the region associated with this food production data.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    /**
     * Get the user who created this food production data.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}