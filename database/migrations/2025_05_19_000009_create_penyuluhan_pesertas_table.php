<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyuluhan_peserta', function (Blueprint $table) {
            $table->id('Id_penyuluhanpeserta');
            $table->foreignId('Id_user')->constrained('users', 'Id_users')->onDelete('cascade');
            $table->foreignId('Id_penyuluhan')->constrained('penyuluhan', 'Id_penyuluhan')->onDelete('cascade');
            $table->enum('status', ['terdaftar', 'hadir']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyuluhan_peserta');
    }
};