<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressNewspapers extends Migration
{
    public function up()
    {
        Schema::create('moonwalkerz_press_newspapers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('web')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_newspapers');
    }
}
