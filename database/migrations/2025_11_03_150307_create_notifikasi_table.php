<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notif');
            $table->string('judul');
            $table->date('tgl_kegiatan');
            $table->time('jam_kegiatan');
            $table->string('kecamatan_kegiatan', 100);
            $table->string('kab_kota', 100);
            $table->string('desa_kegiatan', 100);
            $table->string('rw_kegiatan', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
