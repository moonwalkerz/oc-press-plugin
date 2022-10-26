<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressTagsReleases extends Migration
{
    public function up()
    {
        Schema::create('moonwalkerz_press_releases_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('tag_id');
            $table->bigInteger('release_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_releases_tags');
    }
}
