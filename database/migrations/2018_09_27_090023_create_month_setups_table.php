<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('semester');
            $table->string('type');//不上班日的類別
            $table->string('event_date');//事件日
            $table->string('another_date')->nullable();//1代表這天是補上班日，null是放假日
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
        Schema::dropIfExists('month_setups');
    }
}
