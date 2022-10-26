<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressReviewsCategories extends Migration
{
    public function up()
    {
        Schema::create('moonwalkerz_press_reviews_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('review_id');
            $table->bigInteger('category_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_reviews_categories');
    }
}
