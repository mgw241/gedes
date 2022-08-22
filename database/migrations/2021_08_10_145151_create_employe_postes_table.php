<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployePostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe_postes', function (Blueprint $table) {
            $table->id();
            $table->string('code_emp');
            $table->bigInteger('poste_id')->unsigned();
            $table->date('debut');
            $table->date('fin')->nullable();
            $table->string('statut');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('poste_id')->references('id')->on('postes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employe_postes');
    }
}
