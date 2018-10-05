<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ori_subs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('semester');//學期
            $table->string('ori_teacher');//原先教師
            $table->string('sub_teacher');//代課教師
            $table->string('type');//類別：c_group輔導團；support支援教師；taxation課稅方案；over超鐘點
            $table->text('sections');//代課節次
            $table->unsignedInteger('section');//每週節數，或請假幾節
            $table->string('ps');//備註
            $table->string('abs_date')->nullable();//請假排代時使用
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
        Schema::dropIfExists('ori_subs');
    }
}
