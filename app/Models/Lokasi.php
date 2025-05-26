<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'lokasi';

    protected $primaryKey = 'Id_lokasi';
    protected $fillable = [
        'name',
        'Id_parent',
    ];

    public function parent()
    {
        return $this->belongsTo(Lokasi::class, 'Id_parent', 'Id_lokasi');
    }

    public function children()
    {
        return $this->hasMany(Lokasi::class, 'Id_parent', 'Id_lokasi');
    }
}
