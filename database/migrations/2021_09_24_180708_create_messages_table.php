<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('emp_sender');
            $table->string('emp_getter');
            $table->longText('message');
            $table->integer('lecture')->default('0')->comment('0: non lu | 1: lu');
            $table->timestamps();

            $table->foreign('emp_sender')->references('code')->on('employes')->onDelete('cascade');
            $table->foreign('emp_getter')->references('code')->on('employes')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
