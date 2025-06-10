<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesan_prediksi_pangan', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi');
            $table->string('komoditas');
            $table->string('bulan_tahun');
            $table->text('pesan');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_prediksi_pangan');
    }
};
