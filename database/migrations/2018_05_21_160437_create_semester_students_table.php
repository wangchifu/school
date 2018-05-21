<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semester_students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('semester');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('year_class_id');
            $table->string('num');
            $table->unsignedInteger('at_school')->nullable();
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
        Schema::dropIfExists('semester_students');
    }
}
