<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('codpes');
            $table->string('nompes');
            $table->date('dtanas')->nullable();
            $table->date('dtaflc')->nullable();
            $table->string('sexpes')->nullable();
            $table->string('nomset')->nullable();
            $table->string('email')->nullable();
            $table->string('codset')->nullable();
            $table->string('sitatl')->nullable();
            $table->integer('id_lattes')->nullable();
            $table->string('tipo_vinculo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
