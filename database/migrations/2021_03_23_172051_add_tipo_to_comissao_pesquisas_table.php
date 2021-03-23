<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToComissaoPesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

        Schema::table('comissao_pesquisas', function (Blueprint $table) {
            $table->string('tipo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comissao_pesquisas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
