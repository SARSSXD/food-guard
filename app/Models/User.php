<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 *
 * Represents a user in the food security system with different roles.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property int|null $id_region
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_region',
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the region associated with this user.
     */
    public function region()
    {
        return $this->belongsTo(Wilayah::class, 'id_region');
    }

    /**
     * Get the food production data created by this user.
     */
    public function produksiPangan()
    {
        return $this->hasMany(ProduksiPangan::class, 'created_by');
    }

    /**
     * Get the food price data created by this user.
     */
    public function hargaPangan()
    {
        return $this->hasMany(HargaPangan::class, 'created_by');
    }

    /**
     * Get the food distribution data created by this user.
     */
    public function distribusiPangan()
    {
        return $this->hasMany(DistribusiPangan::class, 'created_by');
    }

    /**
     * Get the subsidy data created by this user.
     */
    public function bantuanSubsidi()
    {
        return $this->hasMany(BantuanSubsidi::class, 'created_by');
    }

    /**
     * Get the nutrition articles written by this user.
     */
    public function artikelGizi()
    {
        return $this->hasMany(ArtikelGizi::class, 'id_penulis');
    }

    /**
     * Get the food prediction data created by this user.
     */
    public function prediksiPangan()
    {
        return $this->hasMany(PrediksiPangan::class, 'created_by');
    }
}
