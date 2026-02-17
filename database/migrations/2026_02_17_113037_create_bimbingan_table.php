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
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaan_akademik_id')->constrained('permintaan_akademiks')->onDelete('cascade');
            $table->string('judul');
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->string('file_path')->nullable();
            $table->string('status_validasi')->default('Menunggu');
            $table->string('divalidasi_oleh')->nullable();
            $table->date('tanggal_validasi')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan');
    }
};
