<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->boolean('is_daring')
                ->default(false)
                ->after('kegiatan');

            $table->json('pjj_menggunakan')
                ->nullable()
                ->after('is_daring');

            $table->string('pjj_lainnya')
                ->nullable()
                ->after('pjj_menggunakan');
        });
    }

    public function down(): void
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->dropColumn([
                'is_daring',
                'pjj_menggunakan',
                'pjj_lainnya',
            ]);
        });
    }
};