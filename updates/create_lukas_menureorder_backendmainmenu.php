<?php namespace Lukas\MenuReorder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLukasMenureorderBackendMainMenu extends Migration
{
    public function up()
    {
        Schema::create('lukas_menureorder_backendmainmenu', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label');
            $table->string('code');
            $table->integer('sort_order')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lukas_menureorder_backendmainmenu');
    }
}
