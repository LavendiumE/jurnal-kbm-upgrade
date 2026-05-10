<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('siswa_izin_keluars', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa_izin_keluars', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable();
            }
        });
    }



   
    public function down(): void
    {
        Schema::table('siswa_izin_keluars', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_izin_keluars', 'kelas_id')) {
                $table->dropColumn('kelas_id');
            }
        });
    }


};