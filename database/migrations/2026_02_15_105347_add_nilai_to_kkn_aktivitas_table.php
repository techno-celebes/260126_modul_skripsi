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
        Schema::table('kkn_aktivitas', function (Blueprint $table) {
            $table->decimal('nilai', 5, 2)->nullable()->after('file_path');
            $table->string('status_validasi')->nullable()->after('nilai');
            $table->string('divalidasi_oleh')->nullable()->after('status_validasi');
            $table->timestamp('tanggal_validasi')->nullable()->after('divalidasi_oleh');
            $table->text('catatan_nilai')->nullable()->after('tanggal_validasi');
            $table->boolean('is_selesai')->default(false)->after('catatan_nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkn_aktivitas', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'status_validasi', 'divalidasi_oleh', 'tanggal_validasi', 'catatan_nilai', 'is_selesai']);
        });
    }
};
