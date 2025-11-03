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
        Schema::create('penarikan', function (Blueprint $table) {
            $table->id('id_tarik');
            $table->foreignId('warga_id')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('ketua_id')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamp('tgl_request')->useCurrent();
            $table->timestamp('tgl_konfirmasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};
