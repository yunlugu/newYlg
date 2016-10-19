<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnsToEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->string('location_id');//数据ID
            $table->string('location_name');//地点名称
            $table->string('location_district');//所属区域，省+市+区（直辖市为“市+区”）
            $table->string('location_adcode');//区域编码，六位区县编码
            $table->string('location_coordinate');//中心点坐标
            // $table->string('location_address');//详细地址
            $table->string('location_typecode');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
