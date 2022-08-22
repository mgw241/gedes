<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectationVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectation_vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_vh');
            $table->string('employe_code');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // FK
            $table->foreign('matricule_vh')->references('matricule')->on('vehicules')->onDelete('cascade');
            $table->foreign('employe_code')->references('code')->on('employes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affectation_vehicules');
    }
}
