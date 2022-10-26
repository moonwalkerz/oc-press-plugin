<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReviews extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_reviews', function($table)
        {
            $table->integer('newspaper_id');
          
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_reviews', function($table)
        {
            $table->dropColumn('newspaper_id');
          
        });
    }
}
