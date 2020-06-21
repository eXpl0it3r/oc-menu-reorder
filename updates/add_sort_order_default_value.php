<?php namespace Lukas\MenuReorder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddDefaultValue extends Migration
{
    public function up()
    {
        Schema::table('lukas_menureorder_backendmainmenu', function ($table) {
            $table->integer('sort_order')->unsigned()->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('lukas_menureorder_backendmainmenu', function ($table) {
            $table->integer('sort_order')->unsigned()->default(null)->change();
        });
    }
}
