<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReleasesTags extends Migration
{
    public function up()
    {
        Schema::rename('moonwalkerz_press_tags_releases', 'moonwalkerz_press_releases_tags');
    }
    
    public function down()
    {
        Schema::rename('moonwalkerz_press_releases_tags', 'moonwalkerz_press_tags_releases');
    }
}
