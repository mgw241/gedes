<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('type_id')->unsigned()->comment("ID de l'abscence, le congé ou la mission...");

            $table->bigInteger('action_id')->unsigned()->comment("ID de l'action, le congé ou la mission...");

            //$table->bigInteger('commentaire_etape_id')->unsigned()->comment("ID du Commentaire des étapes du workflow");

            $table->bigInteger('analyse_id')->unsigned()->comment("ID de l'analyse des étapes du workflow de l'employe");

            $table->string('code_emp_action')->comment("CODE du l'employé qui cree l'action");

            $table->string('code_emp_pre')->comment("CODE du précedent analyseur");

            $table->string('code_emp_respo')->comment("CODE de l'employe qui doit analyser");

            $table->string('code_emp_pro')->comment("CODE du PROCHAIN qui doit analyser");

            //$table->integer('statut')->comment("STATUT de l'action | 5: Suspendu | 2: initiée | 1: Accordé| 0: Refusé ")->default(2);
            //$table->bigInteger('last_analyse_id')->unsigned()->comment("ID du log de la dernière analyse du Workflow")->nullable();

            $table->integer('statut_w')->comment("STATUT du WORKFLOW | 0: En cours | 1: Terminé")->default(0);

            $table->string('commentaire')->comment("Message du workflow");

            //$table->integer('niveau_w')->comment("NIVEAU DU WORKFLOW 5...0")->default(5);

            $table->timestamp('date_attrib')->comment("DATE ATTIRBUTION ");

            $table->string('parcoursw')->comment("workflow d'analyse de la tra nsacton");

            $table->integer('longeur')->comment("NBR de personnes qui analysent le Workflow");

            $table->integer('position')->comment("Position dans le string des analyses Workflow");

            $table->longText('commentairem')->comment("Commentaire lors de l'analyse")->nullable();


            
            $table->timestamps();


            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('type_id')->references('id')->on('workflow_types')->onDelete('cascade');
            //$table->foreign('commentaire_etape_id')->references('id')->on('workflow_commentaires')->onDelete('cascade');
            $table->foreign('code_emp_action')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('analyse_id')->references('id')->on('workflow_analyses')->onDelete('cascade');
            $table->foreign('code_emp_pre')->references('code')->on('employes')->onDelete('cascade');$table->foreign('code_emp_respo')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('code_emp_pro')->references('code')->on('employes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflows');
    }
}
