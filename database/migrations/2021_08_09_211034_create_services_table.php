<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('libelle');
            $table->string('departement_code');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['code']);
            //  FK 
            $table->foreign('departement_code')->references('code')->on('departements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
