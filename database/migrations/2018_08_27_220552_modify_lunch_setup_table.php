<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLunchSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lunch_setups', function (Blueprint $table) {
            $table->float('tea_money')->change();
            $table->float('stud_money')->change();
            $table->float('stud_back_money')->change();
            $table->float('support_part_money')->change();
            $table->float('support_all_money')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lunch_setups', function (Blueprint $table) {
            $table->unsignedInteger('tea_money')->change();
            $table->unsignedInteger('stud_money')->change();
            $table->unsignedInteger('stud_back_money')->change();
            $table->unsignedInteger('support_part_money')->change();
            $table->unsignedInteger('support_all_money')->change();
        });
    }
}
