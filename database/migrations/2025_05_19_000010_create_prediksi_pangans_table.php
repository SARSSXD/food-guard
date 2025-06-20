<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prediksi_pangan', function (Blueprint $table) {
            $table->id('id');
            $table->enum('jenis', ['produksi', 'cadangan']);
            $table->string('komoditas');
            $table->foreignId('id_lokasi')->constrained('wilayah', 'id')->onDelete('cascade');
            $table->date('bulan_tahun');
            $table->float('jumlah');
            $table->string('metode');
            $table->enum('status', ['draft', 'disetujui', 'revisi']);
            $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksi_pangan');
    }
};