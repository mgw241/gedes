<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('code_emp');
            //$table->string('code_emp_missionner');
            $table->string('objet');
            $table->string('pays');
            $table->string('ville');
            $table->date('date_debut');
            $table->date('date_retour');
            $table->integer('duree');
            $table->integer('nbrj_repas');
            $table->integer('nbrj_hebergement');
            $table->string('transport')->default('Voiture');
            $table->integer('nbrj_telephone');
            $table->integer('nbrj_mot');
            $table->integer('nbrj_autre');
            $table->integer('statut')->comment("2: initiée | 1: Accordé| 0: Refusé|")->default(2);
            $table->string('fichier_demande')->nullable();
            $table->string('fichier_ordre')->nullable();
            $table->string('fichier_frais')->nullable();
            $table->timestamps();
            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
            //$table->foreign('code_emp_missionner')->references('code')->on('employes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
}
