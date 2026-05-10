<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keterlambatans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_siswa', 100);

            $table->foreignId('kelas_id')
                  ->constrained('kelas')
                  ->onDelete('cascade');

            $table->text('keterangan')->nullable();

            $table->timestamp('waktu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keterlambatans');
    }
};