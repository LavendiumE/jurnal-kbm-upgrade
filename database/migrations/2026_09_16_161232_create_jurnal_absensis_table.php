<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_absensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jurnal_id')
                  ->constrained('jurnals')
                  ->onDelete('cascade');

            $table->foreignId('siswa_id')
                  ->constrained('siswas')
                  ->onDelete('cascade');

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alfa',
                'pkl',
                'dispensasi',
            ]);

            $table->text('alasan')->nullable();

            $table->timestamps();

            $table->unique(['jurnal_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_absensis');
    }
};