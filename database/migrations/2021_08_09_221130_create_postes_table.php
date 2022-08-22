<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('libelle')->unique();
            $table->string('direction_code');
            $table->string('departement_code');
            $table->bigInteger('service_id')->unsigned();
            $table->mediumText('description');
            $table->string('categorie_code')->default('CAT4');
            $table->bigInteger('hierarchie_id')->unsigned()->default(6);
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code']);
            //  FK 
            $table->foreign('direction_code')->references('code')->on('directions')->onDelete('cascade');
            $table->foreign('departement_code')->references('code')->on('departements')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('categorie_code')->references('code')->on('categorie_postes')->onDelete('cascade');
            $table->foreign('hierarchie_id')->references('id')->on('hierarchies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postes');
    }
}
