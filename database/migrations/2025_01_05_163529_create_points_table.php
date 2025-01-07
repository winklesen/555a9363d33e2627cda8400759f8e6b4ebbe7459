<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->string('group');
            $table->string('point_sesi_satu');
            $table->string('point_sesi_dua');
            $table->string('point_sesi_tiga');
            $table->string('bobot_point_sesi_satu');
            $table->string('bobot_point_sesi_dua');
            $table->string('bobot_point_sesi_tiga');
            $table->string('babak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
