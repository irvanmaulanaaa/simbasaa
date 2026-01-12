<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('konten', function (Blueprint $table) {
            // Kolom penghubung, boleh kosong (nullable) dulu biar data lama aman
            $table->foreignId('id_kategori')
                ->nullable()
                ->after('id_konten')
                ->constrained('kategori_kontens', 'id_kategori')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('konten', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropColumn('id_kategori');
        });
    }
};
