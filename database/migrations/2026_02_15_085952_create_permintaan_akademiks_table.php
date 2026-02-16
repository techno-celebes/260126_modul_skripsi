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
        Schema::create('permintaan_akademiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('nim');
            $table->string('type');
            $table->string('periode')->nullable();
            $table->string('prodi')->nullable();
            $table->string('judul');
            $table->string('dosen_pembimbing')->nullable();
            $table->string('dosen_pembimbing_id')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->date('tanggal_persetujuan')->nullable();
            $table->string('status')->default('Menunggu');
            $table->string('status_proposal')->default('Menunggu');
            $table->string('disetujui_oleh')->nullable();
            $table->boolean('is_selesai')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_akademiks');
    }
};
