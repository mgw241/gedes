<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->bigInteger('sexe')->unsigned();
            $table->date('date_naiss');
            $table->string('nationalite');
            $table->string('adresse');
            $table->string('email')->unique();
            $table->string('image');
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('telephone_travail')->nullable();
            $table->bigInteger('etat_matrimonial')->unsigned();
            $table->bigInteger('enfant')->default(0);
            //$table->bigInteger('permis')->unsigned();

            $table->bigInteger('numero_identite')->unsigned();
            $table->string('numero_cnss')->nullable();
            $table->string('numero_cnamgs')->nullable();
            $table->string('numero_nif')->nullable();

            $table->bigInteger('logement_societe')->unsigned()
            ->default(1);

            $table->string('etat_activite')->comment('actif/retraité/congé...')->default('actif');
            $table->mediumText('motif_depart')->nullable();

            $table->bigInteger('salaire')->default(0);

            $table->timestamps();


            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['code']);
            //  FK 
            $table->foreign('sexe')->references('id')->on('civilites')->onDelete('cascade');
            $table->foreign('logement_societe')->references('id')->on('logement_societes')->onDelete('cascade');
            //$table->foreign('permis')->references('id')->on('permis_conduires')->onDelete('cascade');
            $table->foreign('etat_matrimonial')->references('id')->on('etat_matrimonials')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
