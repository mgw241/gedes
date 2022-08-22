<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('nom');
            $table->string('prenom');
            //$table->date('date_naiss');
            $table->string('image')->nullable();
            $table->string('code_user')->nullable();
            $table->integer('groupe_id')->unsigned(); // a cause du FK
            $table->char('actif')
                    ->default('1')
                    ->comment('1: le groupe est actif, 0:il est inactif/supprimé');
            $table->timestamps();

            /*---------  INDEX   ------------*/
            /* PK
                Pas besoin si on met $table->increments
            */
            
            //  FK Group
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
}
