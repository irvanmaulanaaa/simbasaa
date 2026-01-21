<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('sampah', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('nama_sampah');
        });

        DB::table('sampah')->whereNull('deskripsi')->update(['deskripsi' => '-']);

        DB::statement("ALTER TABLE sampah MODIFY COLUMN deskripsi TEXT NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sampah', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};