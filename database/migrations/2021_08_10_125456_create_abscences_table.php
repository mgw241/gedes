<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbscencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abscences', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code_emp');
            $table->date('date_depart');
            $table->date('date_reprise');
            $table->string('motif');
            /*$table->dateTime('date_depart');
            $table->dateTime('date_reprise');*/
            $table->integer('nbrJ_demande');
            $table->integer('nbrJ_accord')->nullable();
            $table->integer('nbrJ_accord_ssolde')->nullable();
            $table->integer('statut')->comment("2: initiée | 1: Accordé| 0: Refusé|")->default(2);
            $table->integer('justifier')->comment("0: non-justifié | 1: justifié")->default(0);
            $table->string('fichier_justification')->nullable();
            $table->string('fichier_demande')->nullable();
            $table->timestamps();
            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abscences');
    }
}
