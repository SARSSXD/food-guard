<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DistribusiPangan
 *
 * Represents food distribution data in the food security system.
 *
 * @property int $id
 * @property int $id_wilayah_tujuan
 * @property string $komoditas
 * @property float $jumlah
 * @property \Illuminate\Support\Carbon $tanggal_kirim
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class DistribusiPangan extends Model
{
    use HasFactory;

    protected $table = 'distribusi_pangan';

    protected $fillable = [
        'id_wilayah_tujuan',
        'komoditas',
        'jumlah',
        'tanggal_kirim',
        'status',
        'created_by',
    ];

    protected $dates = ['tanggal_kirim'];

    /**
     * Get the destination region for this food distribution.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah_tujuan');
    }

    /**
     * Get the user who created this food distribution data.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
