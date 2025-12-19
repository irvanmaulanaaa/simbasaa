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
        Schema::create('komentars', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->foreignId('konten_id')->constrained('konten', 'id_konten')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->text('isi_komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
