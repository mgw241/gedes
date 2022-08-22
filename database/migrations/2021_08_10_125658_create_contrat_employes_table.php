<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrat_employes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code_emp');
            $table->bigInteger('type_id')->unsigned();
            $table->string('fichier');
            $table->date('date');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code_emp', 'type_id']);
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('contrat_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrat_employes');
    }
}
