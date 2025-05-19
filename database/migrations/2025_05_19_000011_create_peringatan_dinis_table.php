<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peringatan_dini', function (Blueprint $table) {
            $table->id('Id_peringatan');
            $table->enum('jenis', ['kelangkaan', 'bencana', 'harga']);
            $table->foreignId('Id_lokasi')->constrained('lokasi', 'Id_lokasi')->onDelete('cascade');
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->enum('status_respon', ['belum', 'ditindak', 'selesai']);
            $table->text('tindakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peringatan_dini');
    }
};