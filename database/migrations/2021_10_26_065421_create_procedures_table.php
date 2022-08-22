<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('processuses_id')->unsigned();
            $table->string('code');
            $table->string('libelle');
            $table->string('version');
            $table->string('fichier');
            
            $table->string('abreviation');
            $table->integer('nbr_enregistrement');

            $table->integer('statut')->default(1)->comment('1: Actif | 0: Supprimé(desactif)');
            $table->timestamps();

            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code']);
            //  FK 
            $table->foreign('processuses_id')->references('id')->on('processuses')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
}
