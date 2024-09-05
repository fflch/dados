<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_name', function (Blueprint $table) {
            $table->id();
            $table->string('column_name');
            // Add other columns as needed
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('table_name');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
}
