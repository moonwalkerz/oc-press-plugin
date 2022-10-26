<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressReviews extends Migration
{
    public function up()
    {
        Schema::dropIfExists('moonwalkerz_press_reviews');
        Schema::create('moonwalkerz_press_reviews', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('published')->default(1);
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->date('date')->nullable();
            
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_reviews');
    }
}
