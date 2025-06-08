<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wilayah
 *
 * Represents a region (province and city) in the food security system.
 *
 * @property int $id
 * @property string $provinsi
 * @property string $kota
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = ['provinsi', 'kota'];

    /**
     * Get the users associated with this region.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_region');
    }

    /**
     * Get the food production data associated with this region.
     */
    public function produksiPangan()
    {
        return $this->hasMany(ProduksiPangan::class, 'id_lokasi');
    }

    /**
     * Get the food stock data associated with this region.
     */
    public function cadanganPangan()
    {
        return $this->hasMany(CadanganPangan::class, 'id_lokasi');
    }

    /**
     * Get the food price data associated with this region.
     */
    public function hargaPangan()
    {
        return $this->hasMany(HargaPangan::class, 'id_lokasi');
    }

    /**
     * Get the food distribution data associated with this region.
     */
    public function distribusiPangan()
    {
        return $this->hasMany(DistribusiPangan::class, 'id_wilayah_tujuan');
    }

    /**
     * Get the subsidy data associated with this region.
     */
    public function bantuanSubsidi()
    {
        return $this->hasMany(BantuanSubsidi::class, 'id_lokasi');
    }

    /**
     * Get the food prediction data associated with this region.
     */
    public function prediksiPangan()
    {
        return $this->hasMany(PrediksiPangan::class, 'id_lokasi');
    }
}
