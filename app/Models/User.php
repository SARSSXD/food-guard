<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'Id_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'Id_region',
        'created_at',
    ];

    protected $casts = [
        'role' => 'string',
        'created_at' => 'datetime',
    ];

    public function region()
    {
        return $this->belongsTo(Lokasi::class, 'Id_region', 'Id_lokasi');
    }
}