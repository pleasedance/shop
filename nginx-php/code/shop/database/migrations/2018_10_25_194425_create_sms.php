<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 商家短信消息表
         */
        if(!Schema::hasTable('seller_short_message')){
            Schema::create('seller_short_message', function (Blueprint $table) {
                $table->increments('short_msg_id')->comment("短信id");
                $table->string('short_msg_number')->comment("短信模板编号");
                $table->integer('seller_id')->comment("所属商家ID");
                $table->string('issue_personnel')->comment("发布人员");
                $table->dateTime('issue_time')->comment("发布时间");
                $table->integer('msg_count')->comment("接收人数");
                $table->string('msg_content')->comment("短信内容");
                $table->tinyInteger('del_status')->comment("是否删除 【0：未删除，1：删除，默认0】")->default(0);
                $table->dateTime('send_time')->nullable()->comment("定时发送时间");
                $table->tinyInteger('status')->comment("发送状态【0：发送中，1：发送成功，2：发送失败，3：提交成功，4：提交失败，默认0】")->default(0);
                $table->dateTime('created_at')->comment("商家短信消息创建时间");
                $table->dateTime('updated_at')->comment("商家短信消息最近修改信息时间");
                $table->index("short_msg_number");
            });
        }

        /**
         * 商家短信发送记录表
         */
        if(!Schema::hasTable('seller_short_message_sub')){
            Schema::create('seller_short_message_sub', function (Blueprint $table) {
                $table->increments('id')->comment("短信记录id");
                $table->string('phone')->comment("手机号");
                $table->string('short_msg_number')->comment("短信模板编号");
                $table->integer('msg_user')->comment("接受对象ID");
            });
        }

        /**
         * 模板消息表
         */
        if(!Schema::hasTable('wechat_message')){
            Schema::create('wechat_message', function (Blueprint $table) {
                $table->increments('id')->comment("");
                $table->char('temp_id')->comment("模板id");
                $table->string('temp_name')->nullable()->comment("模板消息名称");
                $table->string('temp_key')->nullable()->comment("模板标识");
                $table->text('context')->comment("消息模板 格式json");
                $table->unique('temp_id');
                $table->unique('temp_key');
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
        Schema::drop('seller_short_message');
        Schema::drop('seller_short_message_sub');
        Schema::drop('wechat_message');
    }
}
