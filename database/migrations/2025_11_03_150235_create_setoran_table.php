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
        Schema::create('setoran', function (Blueprint $table) {
            $table->id('id_setor');
            $table->foreignId('warga_id')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('ketua_id')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->decimal('total_harga', 12, 2);
            $table->timestamp('tgl_setor')->useCurrent();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
