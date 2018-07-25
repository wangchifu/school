<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reward_list_id');
            $table->unsignedInteger('reward_id');
            $table->unsignedInteger('user_id');//填報老師
            $table->unsignedInteger('year_class');//得獎班級
            $table->unsignedInteger('student_id');//得獎學生
            $table->text('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winners');
    }
}
