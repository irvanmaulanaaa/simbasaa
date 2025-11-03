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
        Schema::create('saldo', function (Blueprint $table) {
            $table->id('id_saldo');
            $table->foreignId('user_id')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->decimal('jumlah_saldo', 12, 2)->default(0);
            $table->timestamps(); // tgl_update akan diurus oleh updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo');
    }
};
