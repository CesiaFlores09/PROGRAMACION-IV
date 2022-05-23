<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearAdiestramiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Adiestramiento', function (Blueprint $table) {
            $table->unsignedBigInteger('idEspecie');
            $table->string('titulo');
            $table->text('descripcion');
            $table->timestamps();
            $table->foreign('idEspecie')->references('id')->on('Especies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Adiestramiento');
    }
}
