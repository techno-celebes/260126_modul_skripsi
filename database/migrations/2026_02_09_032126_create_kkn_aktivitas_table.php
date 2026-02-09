<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kkn_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkn_id')->constrained('kkn')->onDelete('cascade');
            $table->string('tipe'); // 'harian' atau 'dokumen'
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kkn_aktivitas');
    }
};
