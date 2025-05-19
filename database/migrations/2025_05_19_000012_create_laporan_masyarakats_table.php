<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_masyarakat', function (Blueprint $table) {
            $table->id('Id_laporan');
            $table->foreignId('I_user')->constrained('users', 'Id_users')->onDelete('cascade');
            $table->foreignId('Id_lokasi')->constrained('lokasi', 'Id_lokasi')->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('foto_url')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'selesai', 'tidak valid']);
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_masyarakat');
    }
};