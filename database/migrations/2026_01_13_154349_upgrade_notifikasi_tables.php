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
        if (!Schema::hasColumn('notifikasi', 'jadwal_id')) {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->unsignedBigInteger('jadwal_id')->nullable()->after('id_notif');
                $table->index('jadwal_id');
            });
        }

        Schema::dropIfExists('notifikasi_status');

        Schema::create('notifikasi_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('notifikasi_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('notifikasi_id')->references('id_notif')->on('notifikasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_status');
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn('jadwal_id');
        });
    }
};
