<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressBroadcasts extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_broadcasts', function($table)
        {
            $table->bigInteger('release_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_broadcasts', function($table)
        {
            $table->dropColumn('release_id');
        });
    }
}
