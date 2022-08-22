<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code_emp');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('motif')->nullable();
            $table->string('fichier_justification')->nullable();
            $table->integer('statut')->comment("2: initiée | 1: Accordé| 0: Refusé|")->default(2);
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
        Schema::dropIfExists('conges');
    }
}
