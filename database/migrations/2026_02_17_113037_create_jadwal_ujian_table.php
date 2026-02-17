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
        Schema::create('jadwal_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaan_akademik_id')->constrained('permintaan_akademiks')->onDelete('cascade');
            $table->string('jenis_ujian');
            $table->dateTime('tanggal_ujian');
            $table->string('ruangan')->nullable();
            $table->string('penguji_1')->nullable();
            $table->string('penguji_2')->nullable();
            $table->string('penguji_3')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('Terjadwal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_ujian');
    }
};
