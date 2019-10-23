<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Offers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name',255)->nullable();   
            
            $table->enum('status', ['active', 'deactived', 'moderation'])->default('active');
            $table->integer('rating')->default(0);
            
            $table->integer('price')->default(0);
            $table->enum('currency', ['RUB', 'USD', 'EUR'])->default('RUB');
            $table->enum('sale_type', ['free', 'alternative', 'dupt', 'dzhsk', 'fz214', 'investment', 'pdkp'])->default('free');
            
            $table->integer('area')->default(0);
            $table->string('floor', 10)->nullable();
            $table->integer('rooms')->default(0);
            $table->integer('bedroom')->nullable();
			$table->integer('bathroom')->nullable();
            $table->text('text')->nullable();
            $table->text('quote')->nullable();
            
            $table->string('address')->nullable();
            $table->string('geo_lat')->nullable();
            $table->string('geo_lon')->nullable();
            
            $table->enum('windows_view', ['street', 'yard', 'yardAndStreet'])->nullable();
            $table->enum('repair_type', ['cosmetic', 'design', 'euro', 'no'])->nullable();
            
            $table->integer('cat_id')->unsigned()->nullable();
            $table->foreign('cat_id')->references('id')->on('cats');
            
            $table->enum('parking', ['ground', 'multilevel', 'open', 'roof', 'underground'])->default('open')->nullable();
            
            $table->enum('material_type', ['block', 'boards', 'brick', 'monolith', 'monolithBrick', 'panel', 'stalin', 'wireframe'])->nullable();

            $table->integer('subway_id')->unsigned()->nullable();
            $table->foreign('subway_id')->references('id')->on('subways');
            
            $table->enum('type', ['eliteflat', 'apartment', 'penthouse', 'townhouse'])->nullable();
            
            $table->enum('finish', ['bez-otdelki', 's-otdelkoj'])->nullable();
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->string('slug')->nullable()->index();
            
            $table->enum('publish_terms', ['free', 'paid', 'highlight', 'premium', 'top3'])->default('free')->nullable();
            $table->integer('bet')->nullable();
            $table->boolean('is_export')->default(0)->nullable();
            $table->string('text_cian',255)->nullable();
            
            $table->string('seo_title')->nullable();
            $table->text('seo_descr')->nullable();
            
            $table->string('src_site')->nullable();
            $table->string('src_lot')->nullable();
            $table->string('src_tel')->nullable();
            $table->string('src_link')->nullable();
            $table->text('src_notice')->nullable();
            
            $table->timestamps();
        });
        
        \DB::statement('ALTER TABLE offers AUTO_INCREMENT = 10000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
