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
        Schema::create('desa', function (Blueprint $table) {
            $table->id('id_desa');
            $table->unsignedBigInteger('kecamatan_id');
            $table->string('nama_desa', 100);
            $table->timestamps();

            $table->foreign('kecamatan_id')->references('id_kecamatan')->on('kecamatan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};
