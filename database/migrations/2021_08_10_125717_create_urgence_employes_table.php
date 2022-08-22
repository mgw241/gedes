<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrgenceEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgence_employes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('code_emp');
            $table->string('nom');
            $table->string('lien');
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urgence_employes');
    }
}
