<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel_gizi', function (Blueprint $table) {
            $table->id('id');
            $table->string('judul');
            $table->text('isi');
            $table->enum('kategori', ['anak', 'ibu_hamil', 'lansia', 'lainnya']);
            $table->foreignId('id_penulis')->constrained('users', 'id')->onDelete('cascade');
            $table->integer('jumlah_akses')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel_gizi');
    }
};