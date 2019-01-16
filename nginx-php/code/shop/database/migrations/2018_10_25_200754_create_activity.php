<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 活动表
         */
        if(!Schema::hasTable('activity')){
            Schema::create('activity', function (Blueprint $table) {
                $table->increments('activity_id')->comment("活动id");
                $table->string('title')->comment("活动标题");
                $table->string('picture')->comment("活动图片路径");
                $table->string('remarks')->comment("活动描述");
                $table->tinyInteger('start_status')->comment("上线/下线 【0：下线，1：上线，默认0】")->default(0);
                $table->tinyInteger('status')->comment("状态 【0：进行中，1：未开始, 2：已结束】")->default(1);
                $table->tinyInteger('del_status')->comment("是否删除 【0：未删除，1：删除】")->default(0);
                $table->dateTime('start_time')->comment("开始时间");
                $table->dateTime('end_time')->comment("结束时间");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activity');
    }
}
