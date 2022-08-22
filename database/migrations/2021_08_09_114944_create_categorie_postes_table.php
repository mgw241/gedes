<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriePostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_postes', function (Blueprint $table) {
            $table->string('code');
            $table->string('description')->nullable();
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_postes');
    }
}
