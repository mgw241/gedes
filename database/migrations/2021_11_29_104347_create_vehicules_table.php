<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->string('matricule');
            //$table->bigInteger('modele')->unsigned();
            $table->string('modele');
            $table->bigInteger('marque')->unsigned();
            $table->string('nom')->nullable();
            $table->string('numero_serie')->unique();
            $table->bigInteger('genre')->unsigned();
            $table->bigInteger('source')->unsigned();
            $table->integer('puissance');
            $table->integer('nbr_place');
            $table->integer('charge')->nullable();
            $table->integer('poids_a_vide');
            $table->date('date_achat')->nullable();
            $table->date('date_mise_circulation');
            $table->integer('valeur')->nullable();
            $table->integer('km_actuel')->nullable();
            $table->integer('km_vidanger')->nullable();
            $table->integer('km_alerte1')->nullable();
            $table->integer('km_alerte2')->nullable();
            $table->integer('crique')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('cle_a_roue')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('calle_metal')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('trousseaum')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('baladeuse')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('sangle')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('gilet')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('triangle')->default(0)->comment("0: Non | 1: OUI");
            $table->integer('tracker')->default(0)->comment("0: Non | 1: OUI");
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->timestamps();

            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['matricule']);
            // FK
            //$table->foreign('modele')->references('id')->on('modele_vehicules')->onDelete('cascade');
            $table->foreign('marque')->references('id')->on('marque_vehicules')->onDelete('cascade');
            $table->foreign('source')->references('id')->on('vehicule_sources')->onDelete('cascade');
            $table->foreign('genre')->references('id')->on('vehicule_genres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
}
