<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearConsejos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Consejos', function (Blueprint $table) {
            $table->unsignedBigInteger('idEspecie');
            $table->string('titulo');
            $table->text('consejo');
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
        Schema::dropIfExists('Consejos');
    }
}
