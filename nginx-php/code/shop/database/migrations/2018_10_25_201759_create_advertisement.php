<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 广告表
         */
        if(!Schema::hasTable('advertisement')) {
            Schema::create('advertisement', function (Blueprint $table) {
                $table->increments('ad_id')->comment("广告ID");
                $table->string('ad_name')->comment("广告名称");
                $table->tinyInteger('ad_position')->comment("广告位置【0：小程序首页轮播】");
                $table->tinyInteger('type')->comment("类型 【0：小程序，1：小程序外，默认0】");
                $table->string('ad_picture')->nullable()->comment("广告图片");
                $table->tinyInteger('start_status')->comment("上线/下线 【0：下线，1：上线，默认0】")->default(0);
                $table->integer('click_count')->comment("点击次数")->default(0);
//                $table->integer('order_count')->comment("生成订单")->default(0);
                $table->string('ad_url')->nullable()->comment("广告链接");
                $table->string('remarks')->nullable()->comment("广告备注");
                $table->dateTime('created_at')->comment("创建时间");
//                $table->dateTime('sort_time')->comment("排序时间");
                $table->tinyInteger('del_status')->comment("是否删除 【0：未删除，1：删除】")->default(0);
//                $table->dateTime('start_time')->comment("开始时间");
//                $table->dateTime('end_time')->comment("结束时间");
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
        Schema::drop('advertisement');
    }
}
