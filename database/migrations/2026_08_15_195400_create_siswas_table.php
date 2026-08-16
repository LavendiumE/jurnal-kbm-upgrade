<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            $table->string('nis', 50)->unique();

            $table->string('nama', 150);

            $table->foreignId('kelas_id')
                  ->constrained('kelas')
                  ->onDelete('cascade');

            $table->string('no_hp', 30)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};