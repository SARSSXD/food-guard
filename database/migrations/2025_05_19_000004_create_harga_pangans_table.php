<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harga_pangan', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_pasar');
            $table->string('komoditas');
            $table->float('harga_per_kg');
            $table->foreignId('id_lokasi')->constrained('wilayah', 'id')->onDelete('cascade');
            $table->date('tanggal');
            $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harga_pangan');
    }
};