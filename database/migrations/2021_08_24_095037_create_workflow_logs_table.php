<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_logs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('workflow_id')->unsigned()->comment("ID du Workflow");

            //$table->bigInteger('action_id')->unsigned()->comment("ID de l'action");

            $table->string('code_emp_pre')->comment("CODE du précedent analyseur");

            $table->string('code_emp_respo')->comment("CODE DE L'employe responsable ")->nullable();
            
            $table->string('code_emp_pro')->comment("CODE DU PROCHAIN employe responsable ")->nullable();

            $table->integer('decision')->comment("DECISION prise par l'employe | 5: Suspendu | 2: initiée | 1: Accordé| 0: Refusé ")->default(1);

            $table->integer('workflow_statut')->comment("STATUT du WORKFLOW | 0: En cours | 1: Terminé")->default(0);

            $table->timestamp('le_date_attrib')->comment("DATE ATTRIBUTION de la dernière analyse ")->nullable();

            $table->timestamp('le_date_modif')->comment("DATE MODIFICATION de la dernière analyse ")->nullable();

            //$table->bigInteger('commentaire_id')->unsigned()->comment("ID du comentaire");
            $table->string('commentaire')->comment("Message du workflow");

            //$table->bigInteger('analyse_id')->unsigned()->comment("ID de l'analyse");
            
            //$table->integer('niveau_w')-$table->foreign('code_emp_pre')->references('code')->on('employes')->onDelete('cascade');>comment("NIVEAU DU WORKFLOW 5...0")->default(5);
            $table->longText('commentairem')->comment("Commentaire lors de l'analyse")->nullable();



            $table->timestamps();

            /*---------  INDEX   ------------*/
            //  FK 
            $table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
            //p$table->foreign('commentaire_id')->references('id')->on('workflow_commentaires')->onDelete('cascade');
            //$table->foreign('analyse_id')->references('id')->on('workflow_analyses')->onDelete('cascade');
            $table->foreign('code_emp_pre')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('code_emp_respo')->references('code')->on('employes')->onDelete('cascade');
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
        Schema::dropIfExists('workflow_logs');
    }
}
