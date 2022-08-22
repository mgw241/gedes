<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtincteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extincteurs', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_vh');
            $table->date('obtention');
            $table->date('expiration');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // FK
            $table->foreign('matricule_vh')->references('matricule')->on('vehicules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extincteurs');
    }
}
