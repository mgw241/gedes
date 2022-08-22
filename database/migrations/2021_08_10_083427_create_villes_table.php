<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('libelle');
            $table->string('pays');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            //$table->primary(['libelle']);
            //  FK 
            $table->foreign('pays')->references('libelle')->on('pays')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villes');
    }
}
