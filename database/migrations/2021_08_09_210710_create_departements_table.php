<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->string('libelle');
            $table->string('direction_code');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['code']);
            // FK
            $table->foreign('direction_code')->references('code')->on('directions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departements');
    }
}
