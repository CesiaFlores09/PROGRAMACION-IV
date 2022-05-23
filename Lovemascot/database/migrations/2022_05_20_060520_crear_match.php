<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearMatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Matches', function (Blueprint $table) {
            $table->unsignedBigInteger('de');
            $table->unsignedBigInteger('para');
            $table->tinyInteger('estado')->default(0);
            $table->timestamps();
            $table->foreign('de')->references('id')->on('mascotas');
            $table->foreign('para')->references('id')->on('mascotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Matches');
    }
}
