<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processuses', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code');
            $table->string('libelle');
            $table->string('direction_code');
            
            $table->string('abreviation');
            $table->integer('nbr_procedure');
            
            $table->bigInteger('pilote')->unsigned();
            $table->bigInteger('copilote')->nullable();
            $table->string('version');
            $table->string('fichier');
            $table->integer('statut')->default(1)->comment('1: Actif | 0: Supprimé(desactif)');
            $table->timestamps();

            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code']);
            //  FK 
            $table->foreign('pilote')->references('id')->on('postes')->onDelete('cascade');
            $table->foreign('direction_code')->references('code')->on('directions')->onDelete('cascade');
            /*
            $table->foreign('departement_code')->references('code')->on('departements')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processuses');
    }
}
