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
        Schema::table('jadwal_penimbangan', function (Blueprint $table) {
            $table->string('nama_driver')->after('rw_penimbangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jadwal_penimbangan', function (Blueprint $table) {
            $table->dropColumn('nama_driver');
        });
    }
};
