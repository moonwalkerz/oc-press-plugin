<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReviewsCategories extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_reviews_categories', function($table)
        {
            $table->primary(['review_id','category_id'],'releases_categories');
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_reviews_categories', function($table)
        {
            $table->dropPrimary(['review_id','category_id']);
        });
    }
}
