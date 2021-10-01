<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defesas', function (Blueprint $table) {
            $table->id(); 
            $table->timestamps(); 
            $table->string('defesa_id');
            $table->string('discente_id')->nullable(); 
            $table->string('nompes')->nullable(); 
            $table->date('data_defesa')->nullable(); 
            $table->string('nivpgm')->nullable(); 
            $table->integer('codare')->nullable(); 
            $table->string('nomare')->nullable();
            $table->integer('codcur')->nullable(); 
            $table->string('nomcur')->nullable(); 
            $table->text('titulo')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defesas');
    }
}
