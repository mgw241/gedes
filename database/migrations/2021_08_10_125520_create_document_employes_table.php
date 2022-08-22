<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_employes', function (Blueprint $table) {
            //$table->id()->autoIncrement();
            $table->string('code_emp');
            $table->bigInteger('type_id')->unsigned();
            $table->string('fichier');
            $table->timestamps();
            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['code_emp', 'type_id']);
            //  FK 
            $table->foreign('code_emp')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('document_employe_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_employes');
    }
}
