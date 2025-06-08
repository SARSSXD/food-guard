<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadangan_pangan', function (Blueprint $table) {
            $table->id('id');
            $table->string('komoditas');
            $table->float('jumlah');
            $table->foreignId('id_lokasi')->constrained('wilayah', 'id')->onDelete('cascade');
            $table->enum('status_valid', ['terverifikasi', 'pending']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadangan_pangan');
    }
};