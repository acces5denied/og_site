<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Emails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('subject',255);   
            
            $table->string('name',255)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('email',255)->nullable();
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->text('text')->nullable();

            $table->enum('status', ['callme', 'view', 'plan', 'subscribe', 'price'])->default('callme');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}