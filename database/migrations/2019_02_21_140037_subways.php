<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Subways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('subways', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('city_subway',150)->unique();
            $table->string('slug_subway')->nullable()->index();
            $table->string('city_district',150);
            $table->string('slug_district')->nullable()->index();
            $table->string('city_area',150);
            $table->string('slug_area')->nullable()->index();
            
            $table->text('education')->nullable();
            $table->text('infr')->nullable();
            $table->text('culture')->nullable();
            $table->text('sport')->nullable();
            $table->text('medical')->nullable();
            $table->text('advantages')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subways');
    }
}
