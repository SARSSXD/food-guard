<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_pangan', function (Blueprint $table) {
            $table->id('Id_distribusipangan');
            $table->foreignId('wilayah_tujuan')->constrained('lokasi', 'Id_lokasi')->onDelete('cascade');
            $table->string('komoditas');
            $table->float('volume');
            $table->date('tanggal_kirim');
            $table->enum('status', ['dikirim', 'ditunda', 'terlambat', 'selesai']);
            $table->text('rute');
            $table->foreignId('created_by')->constrained('users', 'Id_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_pangan');
    }
};