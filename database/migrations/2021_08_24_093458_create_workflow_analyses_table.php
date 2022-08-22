<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_analyses', function (Blueprint $table) {
            $table->id();
            $table->string("code_emp")->comment("Code de l'employe");
            $table->string("ordre_analyse_code_emp")->comment("Code des employés qui doivent analyser. séparés par des -");
            $table->timestamps();

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
        Schema::dropIfExists('workflow_analyses');
    }
}
