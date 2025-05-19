<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi_pangan', function (Blueprint $table) {
            $table->id('Id_produksipangan');
            $table->string('komoditas');
            $table->float('volume');
            $table->foreignId('Id_lokasi')->constrained('lokasi', 'Id_lokasi')->onDelete('cascade');
            $table->date('waktu');
            $table->enum('status_valid', ['terverifikasi', 'pending']);
            $table->foreignId('created_by')->constrained('users', 'Id_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_pangan');
    }
};