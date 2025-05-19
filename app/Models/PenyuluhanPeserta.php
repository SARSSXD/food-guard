<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyuluhanPeserta extends Model
{
    use HasFactory;

    protected $primaryKey = 'Id_penyuluhanpeserta';
    protected $fillable = [
        'Id_user',
        'Id_penyuluhan',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_user', 'Id_users');
    }

    public function penyuluhan()
    {
        return $this->belongsTo(Penyuluhan::class, 'Id_penyuluhan', 'Id_penyuluhan');
    }
}