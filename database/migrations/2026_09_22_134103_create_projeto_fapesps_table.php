<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projetos_fapesp', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo');
            $table->string('processo');
            $table->string('pesquisador_responsavel');
            $table->string('bolsista');
            $table->string('nusp')->nullable();
            $table->string('programa')->nullable();
            $table->string('nivel');
            $table->string('grande_area')->nullable();
            $table->string('area')->nullable();
            $table->string('subarea')->nullable();
            $table->dateTime('data_inicio')->nullable();
            $table->dateTime('data_termino')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos_fapesp');
    }
};
