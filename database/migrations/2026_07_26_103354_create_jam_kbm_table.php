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
        Schema::create('jam_kbm', function (Blueprint $table) {

            $table->id();

            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat'
            ]);

            $table->unsignedTinyInteger('jam_ke');

            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->timestamps();

            $table->unique(['hari','jam_ke']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_kbm');
    }
};
