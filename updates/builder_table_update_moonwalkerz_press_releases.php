<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReleases extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_releases', function($table)
        {
            $table->text('excerpt')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_releases', function($table)
        {
            $table->dropColumn('excerpt');
            
        });
    }
}
