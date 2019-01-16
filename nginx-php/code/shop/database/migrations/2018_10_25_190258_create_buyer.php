<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 会员用户表
         */
        if(!Schema::hasTable('buyer_user')){
            Schema::create('buyer_user', function (Blueprint $table) {
                $table->increments('buyer_id')->comment("会员ID");
                $table->string('loginid')->nullable()->comment("会员帐号");
//                $table->string('password')->comment("会员密码");
                $table->string('real_name')->nullable()->comment("会员真实姓名");
                $table->tinyInteger('sex')->comment("会员性别【0:男1:女2:保密】")->default(0);
                $table->string('phone')->nullable()->comment("会员手机号");
                $table->string('head_img')->nullable()->comment("头像");
                $table->string('province')->nullable()->nullable()->comment("会员所属省份");
                $table->string('city')->nullable()->comment("会员所属城市");
                $table->string('area')->nullable()->comment("会员所属区");
                $table->integer('invite_user')->nullable()->comment("邀请人编号ID");
                $table->integer('depart_id')->nullable()->comment("部门ID");
                $table->string('source')->nullable()->comment("会员来源");
                $table->string('job_number')->nullable()->nullable()->comment("工号");
                $table->tinyInteger('status')->comment("会员状态【0:未启用1:启用】")->default(1);
                $table->string('wechat_openid')->nullable()->comment("关联微信");
                $table->string('qq_openid')->nullable()->comment("关联QQ");
                $table->integer('company_id')->nullable()->comment("企业ID");
                $table->decimal('money')->comment("余额")->default(0);
                $table->dateTime('created_at')->comment("会员用户创建时间");
                $table->dateTime('updated_at')->comment("会员用户最近修改信息时间");
//                $table->timestamps();
                $table->index("loginid");
                $table->index("real_name");
                $table->index("status");
            });
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE buyer_user AUTO_INCREMENT=100000");
        }

        /**
         * 用户日志表
         */
        if(!Schema::hasTable('money_log')){
            Schema::create('money_log', function (Blueprint $table) {
                $table->increments('id')->comment("编号ID");
                $table->string('order_sn')->comment("订单编号");
                $table->tinyInteger('order_type')->comment("状态【0:主订单1:子订单2:充值单】");
                $table->tinyInteger('status')->comment("状态【0:消费1:充值】");
                $table->tinyInteger('type')->comment("0企业给用户充值1用户充值2企业给企业充值");
                $table->integer('buyer_id')->comment("用户ID");
                $table->integer('company_id')->comment("企业ID");
                $table->string('ip')->comment("操作ip");
                $table->string('pay_sn')->comment("微信订单号");
                $table->decimal('wx_money')->comment("微信下单金额");
                $table->decimal('user_money')->comment("系统支付/充值金额");
                $table->string('remark')->nullable()->comment("备注");
                $table->dateTime('created_at')->comment("记录创建时间");
                $table->index("created_at");
                $table->index("buyer_id");
            });
        }

        /**
         * 企业充值日志表
         */
        if(!Schema::hasTable('company_money_log')){
            Schema::create('company_money_log', function (Blueprint $table) {
                $table->increments('id')->comment("编号ID");
                $table->integer('company_id')->comment("企业编号ID");
                $table->string('ip')->comment("操作ip");
                $table->decimal('money')->comment("微信下单金额");
                $table->string('remark')->nullable()->comment("备注");
                $table->dateTime('created_at')->comment("记录创建时间");
                $table->index("created_at");
                $table->index("company_id");
            });
        }

        /**
         * 会员成长值表
         */
        if(!Schema::hasTable('buyer_growth_value')){
            Schema::create('buyer_growth_value', function (Blueprint $table) {
                $table->increments('growth_id')->comment("会员成长值编号ID");
                $table->integer('growth_value')->comment("会员成长值");
                $table->integer('buyer_id')->comment("会员编号ID");
            });
        }

        /**
         * 会员成长值明细表
         */
        if(!Schema::hasTable('buyer_growth_details')){
            Schema::create('buyer_growth_details', function (Blueprint $table) {
                $table->increments('detail_id')->comment("成长值明细编号ID");
                $table->integer('buyer_id')->comment("会员ID");
                $table->tinyInteger('detail_type')->comment("变动类型[0增加1减少2冻结减少3手动增加4手动减少]");
                $table->integer('detail_value')->comment("变动数值");
                $table->string('remark')->comment("备注");
                $table->dateTime('created_at')->comment("会员用户创建时间");
                $table->string('source')->comment("来源");
            });
        }

        /**
         * 购物车表
         */
        if(!Schema::hasTable('pd_shopping_cart')){
            Schema::create('pd_shopping_cart', function (Blueprint $table) {
                $table->increments('cart_id')->comment("购物车id");
                $table->integer('seller_id')->nullable()->comment("卖家ID");
                $table->string('sku_unique_code')->comment("sku属性组唯一code");
                $table->string('sku_code')->comment("sku编号");
                $table->string('product_number')->comment("商品唯一code");
                $table->integer('buyer_id')->comment("会员ID");
                $table->integer('product_id')->comment("商品编号ID");
                $table->integer('product_amount')->nullable()->comment("商品对应数量");
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("最近修改信息时间");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
            });
        }

        /**
         * 会员收货信息
         */
        if(!Schema::hasTable('buyer_address')){
            Schema::create('buyer_address', function (Blueprint $table) {
                $table->increments('id')->comment("收货信息ID");
                $table->integer('buyer_id')->comment("会员ID");
                $table->string('name')->comment("姓名");
                $table->string('phone')->comment("手机号");
                $table->string('receive_postal_code')->nullable()->comment("邮政编码");
                $table->string('province')->comment("省份");
                $table->string('city')->comment("城市");
                $table->string('area')->comment("区域");
                $table->string('address')->comment("收货详细地址");
                $table->tinyInteger('is_default')->comment("是否为默认地址【0:否1:是，默认0】");
                $table->tinyInteger('del_status')->comment("是否删除【0未删除1已删除，默认0】");
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
        Schema::drop('buyer_user');
        Schema::drop('money_log');
        Schema::drop('buyer_growth_value');
        Schema::drop('buyer_growth_details');
        Schema::drop('pd_shopping_cart');
        Schema::drop('buyer_address');
        Schema::drop('company_money_log');
    }
}
