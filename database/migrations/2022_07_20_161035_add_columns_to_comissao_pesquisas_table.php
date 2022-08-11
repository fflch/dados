<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToComissaoPesquisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comissao_pesquisas', function (Blueprint $table) {
            $table->string('obs')->nullable();
            $table->string('apoio_financeiro')->nullable();
            $table->string('agencia_fomento')->nullable();
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
            //
        });
    }
}
