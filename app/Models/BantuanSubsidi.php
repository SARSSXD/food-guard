<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BantuanSubsidi
 *
 * Represents subsidy or aid distribution data in the food security system.
 *
 * @property int $id
 * @property string $jenis
 * @property int $id_lokasi
 * @property \Illuminate\Support\Carbon $tanggal
 * @property int $jumlah_penerima
 * @property string|null $keterangan
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class BantuanSubsidi extends Model
{
    use HasFactory;

    protected $table = 'bantuan_subsidi';

    protected $fillable = [
        'jenis',
        'id_lokasi',
        'tanggal',
        'jumlah_penerima',
        'keterangan',
        'created_by',
    ];

    protected $dates = ['tanggal'];

    /**
     * Get the region associated with this subsidy data.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_lokasi');
    }

    /**
     * Get the user who created this subsidy data.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
