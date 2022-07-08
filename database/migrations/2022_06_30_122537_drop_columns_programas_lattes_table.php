<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsProgramasLattesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lattes', function (Blueprint $table) {
            $table->dropColumn('codare');
            $table->dropColumn('nivpgm');
            $table->dropColumn('tipo_pessoa');
            

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lattes', function (Blueprint $table) {
            $table->integer('codare')->nullable();
            $table->string('nivpgm')->nullable();
            $table->string('tipo_pessoa')->nullable();
        });
    }
}
