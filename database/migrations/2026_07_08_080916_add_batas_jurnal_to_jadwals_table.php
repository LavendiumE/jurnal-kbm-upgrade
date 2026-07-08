<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {

            $table->boolean('use_default_batas_jurnal')
                  ->default(true)
                  ->after('jam_selesai');

            $table->unsignedInteger('batas_jurnal_menit')
                  ->nullable()
                  ->after('use_default_batas_jurnal');

        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {

            $table->dropColumn([
                'use_default_batas_jurnal',
                'batas_jurnal_menit'
            ]);

        });
    }
};