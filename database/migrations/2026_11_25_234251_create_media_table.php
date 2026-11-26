<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->unique();
            $table->enum('jenis', ['video', 'digital_reading']);
            $table->string('genre');
            $table->string('pembuat')->nullable(); // Sutradara (Video) atau Penulis (DigitalReading)
            $table->year('tahun_rilis')->nullable();
            $table->unsignedInteger('durasi_atau_halaman')->nullable(); // Menit atau Jumlah Halaman
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
