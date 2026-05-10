<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_terlambats', function (Blueprint $table) {

            $table->string('paraf_guru')
                ->nullable()
                ->after('pembinaan');

        });
    }

    public function down(): void
    {
        Schema::table('siswa_terlambats', function (Blueprint $table) {

            $table->dropColumn('paraf_guru');

        });
    }
};