<?php namespace MoonWalkerz\Press\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMoonwalkerzPressReleases extends Migration
{
    public function up()
    {
        Schema::dropIfExists('moonwalkerz_press_releases');
        Schema::create('moonwalkerz_press_releases', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('published')->default(1);
            $table->boolean('featured')->default(0);
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('published_until')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('gallery')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('moonwalkerz_press_releases');
    }
}
