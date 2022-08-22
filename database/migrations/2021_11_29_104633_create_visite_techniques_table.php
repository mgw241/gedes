<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisiteTechniquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visite_techniques', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_vh');
            $table->date('date_emission');
            $table->integer('duree');
            $table->date('date_expiration');
            $table->string('fichier')->nullable();
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
        Schema::dropIfExists('visite_techniques');
    }
}
