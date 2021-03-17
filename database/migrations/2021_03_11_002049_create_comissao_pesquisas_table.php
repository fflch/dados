<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissaoPesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissao_pesquisas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('codproj')->nullable();
            $table->integer('codpes_discente')->nullable();
            $table->string('nome_discente')->nullable();
            $table->integer('codpes_supervisor')->nullable();
            $table->string('nome_supervisor')->nullable();
            $table->string('titulo_pesquisa')->nullable();
            $table->datetime('data_ini')->nullable();
            $table->datetime('data_fim')->nullable();
            $table->integer('ano_proj')->nullable();
            $table->string('bolsa')->nullable();
            $table->integer('cod_departamento')->nullable();
            $table->string('sigla_departamento')->nullable();
            $table->string('nome_departamento')->nullable();
            $table->integer('cod_curso')->nullable();
            $table->string('nome_curso')->nullable();
            $table->integer('cod_area')->nullable();
            $table->string('nome_area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comissao_pesquisa');
    }
}
