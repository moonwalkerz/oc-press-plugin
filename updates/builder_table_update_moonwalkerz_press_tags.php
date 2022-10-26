<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMoonwalkerzPressTags extends Migration
{
    public function up()
    {
        Schema::table('moonwalkerz_press_tags', function($table)
        {
            $table->string('slug');
          
        });
    }
    
    public function down()
    {
        Schema::table('moonwalkerz_press_tags', function($table)
        {
            $table->dropColumn('slug');
            
        });
    }
}
