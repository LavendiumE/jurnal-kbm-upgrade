
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_izin_keluars', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('nis');
        });

        Schema::table('siswa_pulang_awals', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('nis');
        });

        Schema::table('siswa_terlambats', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('nis');
        });
    }

    public function down(): void
    {
        Schema::table('siswa_izin_keluars', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });

        Schema::table('siswa_pulang_awals', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });

        Schema::table('siswa_terlambats', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
