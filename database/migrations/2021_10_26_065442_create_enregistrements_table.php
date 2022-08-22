<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnregistrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enregistrements', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->bigInteger('procedure_id')->unsigned();
            $table->bigInteger('type')->unsigned();
            $table->string('libelle');
            $table->string('version');
            $table->string('fichier');
            $table->integer('statut')->default(1)->comment('1: Actif | 0: Supprimé(desactif)');
            $table->timestamps();

            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code']);
            //  FK 
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('type_enregistrements')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enregistrements');
    }
}
