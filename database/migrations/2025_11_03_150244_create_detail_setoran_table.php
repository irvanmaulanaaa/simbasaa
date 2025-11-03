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
        Schema::create('detail_setoran', function (Blueprint $table) {
            $table->id('id_detail_setor');
            $table->foreignId('setor_id')->constrained('setoran', 'id_setor')->cascadeOnDelete();
            $table->foreignId('sampah_id')->constrained('sampah', 'id_sampah')->cascadeOnDelete();
            $table->decimal('berat', 8, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_setoran');
    }
};
