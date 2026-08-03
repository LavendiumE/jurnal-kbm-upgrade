<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // IZIN KELUAR
        DB::statement("
            UPDATE siswa_izin_keluars
            SET tanggal = DATE(created_at)
            WHERE tanggal IS NULL
        ");

        // PULANG AWAL
        DB::statement("
            UPDATE siswa_pulang_awals
            SET tanggal = DATE(created_at)
            WHERE tanggal IS NULL
        ");

        // SISWA TERLAMBAT
        DB::statement("
            UPDATE siswa_terlambats
            SET tanggal = DATE(created_at)
            WHERE tanggal IS NULL
        ");
    }

    public function down(): void
    {
        //
    }
};