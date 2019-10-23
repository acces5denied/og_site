<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Propertyables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propertyables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propertyable_id')->unsigned()->index();          
            $table->string('propertyable_type', 50);
            $table->integer('property_id')->unsigned()->index();
            $table->foreign('property_id')->references('id')->on('propertys')->onDelete('cascade');
            $table->string('property_value', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propertyables');
    }
}
