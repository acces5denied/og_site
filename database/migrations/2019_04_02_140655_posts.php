<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->string('image')->nullable();
            $table->text('text')->nullable();
			$table->text('quote')->nullable();
			$table->boolean('is_top')->default(0)->nullable();
			$table->string('slug')->nullable()->index();
			$table->string('seo_title')->nullable();
            $table->text('seo_descr')->nullable();
            
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
        Schema::dropIfExists('posts');
    }
}
