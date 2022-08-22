<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupe_forms', function (Blueprint $table) {
            $table->integer('group_id')->unsigned();    //  FK id Groupes & PK
            $table->integer('form_id')->unsigned();     //  FK id Forms & PK
            $table->char('read')->default(0);
            $table->char('add')->default(0);
            $table->char('edit')->default(0);
            $table->char('delete')->default(0);
            $table->timestamps();

            /*---------  INDEX   ------------*/
            // PK
            $table->primary(['group_id', 'form_id']);
            
            //  FK Group
            $table->foreign('group_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupe_forms');
    }
}
