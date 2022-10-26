<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressBroadcasts extends Migration
{
    public function up()
    {
        Schema::create('moonwalkerz_press_broadcasts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->boolean('sent')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_broadcasts');
    }
}
