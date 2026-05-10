<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_terlambats', function (Blueprint $table) {
            $table->id();

            $table->string('nama_siswa');
            $table->string('nis');

            $table->foreignId('kelas_id')->nullable();
            $table->foreignId('guru_pembina_id')->nullable();

            $table->time('jam_terlambat');

            $table->text('alasan')->nullable();
            $table->text('pembinaan')->nullable();

            $table->foreignId('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_terlambats');
    }
};