<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('guru_id')
                  ->constrained('gurus')
                  ->onDelete('cascade');

            $table->foreignId('kelas_id')
                  ->constrained('kelas')
                  ->onDelete('cascade');

            $table->foreignId('jadwal_id')
                  ->nullable()
                  ->constrained('jadwals')
                  ->onDelete('set null');

            $table->enum('tipe', ['guru', 'piket']);

            // Isi jurnal
            $table->text('materi')->nullable();
            $table->text('kegiatan')->nullable();

            // Kehadiran
            $table->unsignedInteger('hadir')->nullable();

            $table->text('izin')->nullable();   // bisa nama siswa
            $table->text('sakit')->nullable();  // bisa nama siswa
            $table->text('alfa')->nullable();   // bisa nama siswa

            $table->boolean('pkl')->default(false);

            // Dokumentasi
            $table->string('foto', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};