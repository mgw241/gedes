<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVidangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vidanges', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_vh');
            $table->bigInteger('concessionnaire')->unsigned();
            $table->date('date');
            $table->integer('km_actuel');
            $table->char('type', 1);
            $table->integer('prix');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // FK
            $table->foreign('matricule_vh')->references('matricule')->on('vehicules')->onDelete('cascade');
            $table->foreign('concessionnaire')->references('id')->on('concessionnaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vidanges');
    }
}
