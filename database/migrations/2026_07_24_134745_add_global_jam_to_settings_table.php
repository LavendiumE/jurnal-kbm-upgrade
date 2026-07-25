<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->time('jam1_mulai')->default('07:00');
            $table->time('jam1_selesai')->default('07:45');

            $table->time('jam2_mulai')->default('07:45');
            $table->time('jam2_selesai')->default('08:30');

            $table->time('jam3_mulai')->default('08:30');
            $table->time('jam3_selesai')->default('09:15');

            $table->time('jam4_mulai')->default('09:30');
            $table->time('jam4_selesai')->default('10:15');

            $table->time('jam5_mulai')->default('10:15');
            $table->time('jam5_selesai')->default('11:00');

            $table->time('jam6_mulai')->default('11:00');
            $table->time('jam6_selesai')->default('11:45');

            $table->time('jam7_mulai')->default('12:30');
            $table->time('jam7_selesai')->default('13:15');

            $table->time('jam8_mulai')->default('13:15');
            $table->time('jam8_selesai')->default('14:00');

            $table->time('jam9_mulai')->default('14:00');
            $table->time('jam9_selesai')->default('14:45');

            $table->time('jam10_mulai')->default('14:45');
            $table->time('jam10_selesai')->default('15:30');

        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->dropColumn([
                'jam1_mulai','jam1_selesai',
                'jam2_mulai','jam2_selesai',
                'jam3_mulai','jam3_selesai',
                'jam4_mulai','jam4_selesai',
                'jam5_mulai','jam5_selesai',
                'jam6_mulai','jam6_selesai',
                'jam7_mulai','jam7_selesai',
                'jam8_mulai','jam8_selesai',
                'jam9_mulai','jam9_selesai',
                'jam10_mulai','jam10_selesai',
            ]);

        });
    }
};