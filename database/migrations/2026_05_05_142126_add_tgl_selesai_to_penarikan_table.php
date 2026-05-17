<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penarikan', function (Blueprint $table) {
            $table->timestamp('tgl_selesai')->nullable()->after('tgl_konfirmasi');
        });

        DB::statement("ALTER TABLE penarikan MODIFY COLUMN status ENUM('pending', 'disetujui', 'selesai', 'ditolak') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE penarikan MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak') DEFAULT 'pending'");
        
        Schema::table('penarikan', function (Blueprint $table) {
            $table->dropColumn('tgl_selesai');
        });
    }
};