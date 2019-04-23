<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntosCompradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos_comprados', function (Blueprint $table) {
            $table->increments('id');
           $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users')->OnDelete('cascade');
            $table->integer('puntos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntos_comprados');
    }
}
