<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReleasesTags2 extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_releases_tags', function($table)
        {
            $table->dropPrimary(['tag_id','release_id']);
            $table->primary(['tag_id','release_id']);
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_releases_tags', function($table)
        {
            $table->dropPrimary(['tag_id','release_id']);
        });
    }
}
