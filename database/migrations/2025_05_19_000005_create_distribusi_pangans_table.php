<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_pangan', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_wilayah_tujuan')->constrained('wilayah', 'id')->onDelete('cascade');
            $table->string('komoditas');
            $table->float('jumlah');
            $table->date('tanggal_kirim');
            $table->enum('status', ['dikirim', 'ditunda', 'terlambat', 'selesai']);
            $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_pangan');
    }
};