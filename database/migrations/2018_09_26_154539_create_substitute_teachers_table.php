<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubstituteTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substitute_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_name');//代課老師
            $table->string('ps')->nullable();//備註
            $table->tinyInteger('active');//1啟用，2停用
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
        Schema::dropIfExists('substitute_teachers');
    }
}
