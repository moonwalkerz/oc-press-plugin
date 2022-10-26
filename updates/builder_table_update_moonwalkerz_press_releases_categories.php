<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReleasesCategories extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_releases_categories', function($table)
        {
            $table->dropPrimary(['release_id','category_id']);
            $table->primary(['release_id','category_id'],'releases_categories');
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_releases_categories', function($table)
        {
            $table->dropPrimary(['release_id','category_id']);
        });
    }
}
