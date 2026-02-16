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
        Schema::table('permintaan_akademik_progress', function (Blueprint $table) {
            $table->decimal('nilai', 5, 2)->nullable()->after('tanggal_validasi');
            $table->text('catatan_nilai')->nullable()->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaan_akademik_progress', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'catatan_nilai']);
        });
    }
};
