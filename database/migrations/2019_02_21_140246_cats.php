<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name',128)->unique();
			$table->string('name_alt',128)->unique();
            $table->integer('rating')->default(0);
            
            $table->string('address')->nullable();
            $table->string('geo_lat')->nullable();
            $table->string('geo_lon')->nullable();
            
            $table->text('text')->nullable();
            $table->text('quote')->nullable();
            
            $table->integer('subway_id')->unsigned()->nullable();
            $table->foreign('subway_id')->references('id')->on('subways');
            
            $table->enum('parking', ['ground', 'multilevel', 'open', 'roof', 'underground'])->default('open')->nullable();
			
			$table->enum('security', ['yes', 'no'])->nullable();
            
            $table->enum('material_type', ['block', 'boards', 'brick', 'monolith', 'monolithBrick', 'panel', 'stalin', 'wireframe'])->nullable();
            
            $table->boolean('is_complete')->default(0)->nullable();
            $table->enum('quarter', ['first', 'second', 'third', 'fourth'])->nullable();
            $table->integer('deadline_year')->nullable();
            
            $table->string('slug')->nullable()->index();
            $table->string('seo_title')->nullable();
            $table->text('seo_descr')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
