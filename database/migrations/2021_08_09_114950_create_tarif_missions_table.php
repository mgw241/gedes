<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_missions', function (Blueprint $table) {
            $table->id();
            $table->integer('hebergement');
            $table->integer('restauration');
            $table->integer('divers');
            $table->string('categorie_code');
            $table->timestamps();

            $table->foreign('categorie_code')->references('code')->on('categorie_postes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarif_missions');
    }
}
