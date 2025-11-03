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
        Schema::create('jadwal_penimbangan', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('user_id')->constrained('users', 'id_user'); 
            $table->foreignId('desa_id')->constrained('desa', 'id_desa');
            $table->string('rw_penimbangan', 5);
            $table->time('jam_penimbangan');
            $table->date('tgl_jadwal');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penimbangan');
    }
};
