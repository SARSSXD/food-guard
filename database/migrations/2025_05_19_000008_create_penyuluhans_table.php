<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyuluhan', function (Blueprint $table) {
            $table->id('Id_penyuluhan');
            $table->string('judul');
            $table->string('jenis');
            $table->date('tanggal');
            $table->foreignId('Id_lokasi')->constrained('lokasi', 'Id_lokasi')->onDelete('cascade');
            $table->integer('kuota');
            $table->foreignId('created_by')->constrained('users', 'Id_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyuluhan');
    }
};