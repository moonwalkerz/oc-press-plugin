<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressReleasesCategories extends Migration
{
    public function up()
    {
        Schema::dropIfExists('moonwalkerz_press_releases_categories');

        Schema::create('moonwalkerz_press_releases_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('release_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['release_id', 'category_id'],'mm_press_categories');
        });

    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_releases_categories');
    }
}
