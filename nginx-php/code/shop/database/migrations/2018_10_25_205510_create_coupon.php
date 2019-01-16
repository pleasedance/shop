<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 优惠券表
         */
        if(!Schema::hasTable('coupon')){
            Schema::create('coupon', function (Blueprint $table) {
                $table->increments('coupon_id')->comment("优惠券id");
                $table->integer('seller_id')->comment("商家id 【0：官方】")->default(0);
                $table->string('coupon_name')->comment("优惠券名称");
                $table->tinyInteger('platform')->comment("适用平台【0：全平台，1：pc端：2：移动端】")->default(0);
                $table->integer('circulation')->comment("总发行量")->default(0);
                $table->integer('receive_count')->comment("领取数量")->default(0);
                $table->integer('use_count')->comment("已使用数量")->default(0);
                $table->decimal('denomination',8,2)->comment("面额")->default(0);
                $table->integer('restrict_count')->comment("每人限制数量")->default(1);
                $table->decimal('use_restrict',8,2)->comment("使用限制 【0：无限制】")->default(0);
                $table->dateTime('start_time')->comment("有效期开始时间");
                $table->dateTime('end_time')->comment("有效期到期时间");
                $table->dateTime('overdue_day')->comment("指定过期天数");
                $table->tinyInteger('product_restrict_type')->comment("产品限制 【0：全场通用，1：指定分类】")->default(0);
                $table->string('product_restrict')->comment("限制商品类型的id");
                $table->string('remarks')->comment("备注");
                $table->dateTime('created_at')->comment("创建时间");
                $table->tinyInteger('del_status')->comment("是否删除 【0：未删除，1：删除】")->default(0);
                $table->tinyInteger('coupon_type')->comment("优惠券类型 【0：注册赠券，1：购物赠券，2：全场赠券，3：会员赠券，4：主动领取】")->default(0);
                $table->index("start_time");
                $table->index("end_time");
            });
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE coupon AUTO_INCREMENT=1000");
        }

        /**
         * 用户优惠券表
         */
        if(!Schema::hasTable('coupon_user')){
            Schema::create('coupon_user', function (Blueprint $table) {
                $table->increments('coupon_user_id')->comment("用户优惠券id");
                $table->integer('coupon_id')->comment("优惠券id");
                $table->integer('buyer_id')->comment("商家id 【0：官方】")->default(0);
                $table->string('coupon_name')->comment("优惠券名称");
                $table->decimal('denomination',8,2)->comment("面额")->default(0);
                $table->decimal('use_restrict',8,2)->comment("使用限制 【0：无限制】")->default(0);
                $table->dateTime('start_time')->comment("有效期开始时间");
                $table->dateTime('end_time')->comment("有效期到期时间");
                $table->dateTime('overdue_day')->comment("指定过期天数");
                $table->tinyInteger('product_restrict_type')->comment("产品限制 【0：全场通用，1：指定分类】")->default(0);
                $table->tinyInteger('coupon_type')->comment("优惠券类型 【0：注册赠券，1：购物赠券，2：全场赠券，3：会员赠券，4：主动领取】")->default(0);
                $table->index("start_time");
                $table->index("end_time");
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
        Schema::drop('coupon');
        Schema::drop('coupon_user');
    }
}
