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
        Schema::create('sampah', function (Blueprint $table) {
            $table->id('id_sampah');
            $table->foreignId('kategori_id')->constrained('kategori_sampah', 'id_kategori')->cascadeOnDelete();
            $table->foreignId('diinput_oleh')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('harga_diupdate_oleh')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('nama_sampah');
            $table->string('kode_sampah', 20)->unique();
            $table->string('kode_bsb', 20)->nullable();
            $table->decimal('harga_anggota', 10, 2)->default(0);
            $table->decimal('harga_bsb', 10, 2)->default(0);
            $table->enum('UOM', ['kg', 'pcs']);
            $table->enum('status_sampah', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamp('tgl_nonaktif')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampah');
    }
};
