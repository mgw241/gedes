<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeEnfantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe_enfants', function (Blueprint $table) {
            $table->id();
            $table->string('code_emp');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->date('date_naissance');
            $table->string('scolarite');
            $table->string('nom_conjoint');
            $table->string('profession_conjoint')->nullable();
            $table->string('telephone')->nullable();
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
        Schema::dropIfExists('employe_enfants');
    }
}
