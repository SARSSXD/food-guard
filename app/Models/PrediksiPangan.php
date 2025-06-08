<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PrediksiPangan
 *
 * Represents food production and stock predictions in the food security system.
 *
 * @property int $id
 * @property string $jenis
 * @property string $komoditas
 * @property int $id_lokasi
 * @property \Illuminate\Support\Carbon $bulan_tahun
 * @property float $jumlah
 * @property string $metode
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class PrediksiPangan extends Model
{
    use HasFactory;

    protected $table = 'prediksi_pangan';

    protected $fillable = [
        'jenis',
        'komoditas',
        'id_lokasi',
        'bulan_tahun',
        'jumlah',
        'metode',
        'status',
        'created_by',
    ];

    protected $dates = ['bulan_tahun'];

    /**
     * Get the region associated with this prediction data.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    /**
     * Get the user who created this prediction data.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
