<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressReleases2 extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_releases', function($table)
        {
            $table->boolean('show_attachments')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_releases', function($table)
        {
            $table->dropColumn('show_attachments');
        });
    }
}
