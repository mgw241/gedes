<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->string('code');
            $table->string('libelle');
            $table->bigInteger('type_procedure')->unsigned()->default(1);
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['code']);

            $table->foreign('type_procedure')->references('id')->on('type_procedures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directions');
    }
}