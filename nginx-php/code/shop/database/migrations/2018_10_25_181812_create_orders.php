<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 订单表
         */
        if(!Schema::hasTable('order')){
            Schema::create('order', function (Blueprint $table) {
                $table->string('order_sn')->comment("订单编号");
                $table->integer('buyer_id')->comment("下单用户ID");
                $table->string('pay_sn')->nullable()->comment("支付单号");
                $table->string('buyer_phone')->nullable()->comment("下单用户手机号");
                $table->decimal('need_pay_money')->comment("需要支付总金额【默认0】")->default(0);
                $table->decimal('product_money')->comment("累计商品金额【默认0】")->default(0);
                $table->decimal('payment_money')->comment("累计支付金额【默认0】")->default(0);
                $table->decimal('discount_money')->comment("累计优惠金额【默认0】")->default(0);
                $table->decimal('activity_money')->comment("累计活动优惠金额【默认0】")->default(0);
                $table->decimal('shipping_money')->comment("累计运费金额【默认0】")->default(0);
                $table->decimal('return_goods_money')->comment("累计退货金额【默认0】")->default(0);
//                $table->decimal('le_gold_money')->comment("乐币抵扣金额【默认0】")->default(0);
                $table->tinyInteger('payment_method')->nullable()->comment("支付方式【0:微信支付1:余额支付，默认0】");
                $table->tinyInteger('order_source')->comment("订单来源【0app1wap，默认0】")->default(0);
                $table->string('order_remark')->nullable()->comment("订单备注");
                $table->tinyInteger('order_status')->nullable()->comment("订单状态【0无效1有效，默认1】")->default(1);
                $table->tinyInteger('send_status')->nullable()->comment("物流状态【0未发货1已发货，默认0】")->default(0);
                $table->tinyInteger('pay_status')->nullable()->comment("支付状态【0未支付1已支付，默认0】")->default(0);
                $table->tinyInteger('receipt_status')->nullable()->comment("收货状态【0未收货1已收货，默认0】")->default(0);
                $table->tinyInteger('evaluation_status')->nullable()->comment("评价状态【0未评价1已评价，默认0】")->default(0);
                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0未退款1已退款，默认0】")->default(0);
                $table->tinyInteger('return_goods_status')->nullable()->comment("退货状态【0未退货1已退货，默认0】")->default(0);
                $table->tinyInteger('deal_status')->nullable()->comment("处理状态【0申请中1同意2拒绝，默认0】")->default(0);
                $table->string('receive_province')->comment("收货省");
                $table->string('receive_city')->comment("收货市");
                $table->string('receive_area')->comment("收货区");
                $table->string('receive_address')->comment("收货详细地址");
                $table->string('receive_postal_code')->nullable()->comment("邮政编码");
                $table->string('receive_name')->comment("收货人姓名");
                $table->string('receive_phone')->comment("收货人手机号");
                $table->tinyInteger('order_type')->comment("订单类型【0：普通订单】")->default(0);
                $table->decimal('total_growth')->comment("订单可获得成长值")->default(0);
//                $table->decimal('total_le_glod')->comment("订单可获得乐币")->default(0);
                $table->integer('coupon_id')->nullable()->comment("优惠券ID");
                $table->integer('activity_id')->nullable()->comment("活动ID");
                $table->dateTime('complete_time')->nullable()->comment("订单完成时间");
                $table->dateTime('shipping_time')->nullable()->comment("发货时间");
                $table->dateTime('payment_time')->nullable()->comment("支付时间");
                $table->tinyInteger('complete_type')->nullable()->comment("确认收货类型【0自动1手动】");
                $table->string('shipping_sn')->nullable()->comment("快递单号");
                $table->string('shipping_comp_name')->nullable()->comment("快递公司名称");
                $table->string('invoice_number')->nullable()->comment("发票唯一code");
                $table->dateTime('created_at')->comment("订单创建时间");
                $table->dateTime('updated_at')->comment("订单最近修改信息时间");
//                $table->timestamps();
                $table->index("buyer_id");
                $table->index("pay_sn");
                $table->primary("order_sn");
            });
        }

        /**
         * 子订单表
         */
        if(!Schema::hasTable('order_sub')){
            Schema::create('order_sub', function (Blueprint $table) {
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->string('order_sn')->comment("订单编号");
                $table->integer('buyer_id')->nullable()->comment("下单用户ID");
                $table->integer('seller_id')->comment("商家ID");
                $table->string('buyer_phone')->nullable()->comment("下单用户手机号");
                $table->decimal('need_pay_money')->comment("需要支付金额【默认0】")->default(0);
                $table->decimal('product_money')->comment("商品金额【默认0】")->default(0);
                $table->decimal('payment_money')->comment("支付金额【默认0】")->default(0);
                $table->decimal('discount_money')->comment("优惠金额【默认0】")->default(0);
                $table->decimal('activity_money')->comment("活动优惠金额【默认0】")->default(0);
                $table->decimal('shipping_money')->comment("运费金额【默认0】")->default(0);
                $table->decimal('return_goods_money')->comment("总退货金额【默认0】")->default(0);
                $table->decimal('le_gold_money')->comment("乐币抵扣金额【默认0】")->default(0);
                $table->tinyInteger('payment_method')->nullable()->comment("支付方式【0:微信支付1:余额支付，默认0】");
                $table->tinyInteger('order_source')->comment("订单来源【0app1wap，默认0】")->default(0);
                $table->string('order_remark')->nullable()->comment("订单备注");
                $table->tinyInteger('order_status')->nullable()->comment("订单状态【0无效1有效，默认1】")->default(1);
                $table->tinyInteger('send_status')->nullable()->comment("物流状态【0未发货1已发货，默认0】")->default(0);
                $table->tinyInteger('pay_status')->nullable()->comment("支付状态【0未支付1已支付，默认0】")->default(0);
                $table->tinyInteger('receipt_status')->nullable()->comment("收货状态【0未收货1已收货，默认0】")->default(0);
                $table->tinyInteger('evaluation_status')->nullable()->comment("评价状态【0未评价1已评价，默认0】")->default(0);
                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0未退款1已退款，默认0】")->default(0);
                $table->tinyInteger('return_goods_status')->nullable()->comment("退货状态【0未退货1已退货，默认0】")->default(0);
                $table->tinyInteger('deal_status')->nullable()->comment("处理状态【0申请中1同意2拒绝，默认0】")->default(0);
                $table->string('receive_province')->comment("收货省");
                $table->string('receive_city')->comment("收货市");
                $table->string('receive_area')->comment("收货区");
                $table->string('receive_address')->comment("收货详细地址");
                $table->string('receive_postal_code')->nullable()->comment("邮政编码");
                $table->string('receive_name')->comment("收货人姓名");
                $table->string('receive_phone')->comment("收货人手机号");
                $table->tinyInteger('order_type')->comment("订单类型【0：普通订单】")->default(0);
                $table->decimal('total_growth')->comment("订单可获得成长值")->default(0);
//                $table->decimal('total_le_glod')->comment("订单可获得乐币")->default(0);
                $table->integer('coupon_id')->nullable()->comment("优惠券ID");
                $table->integer('activity_id')->nullable()->comment("活动ID");
                $table->dateTime('complete_time')->nullable()->comment("订单完成时间");
                $table->dateTime('shipping_time')->nullable()->comment("发货时间");
                $table->dateTime('payment_time')->nullable()->comment("支付时间");
                $table->tinyInteger('complete_type')->nullable()->comment("确认收货类型【0自动1手动】");
                $table->string('shipping_sn')->nullable()->comment("快递单号");
                $table->string('shipping_comp_name')->nullable()->comment("快递公司名称");
                $table->string('shipping_comp_code')->nullable()->comment("快递编号");
                $table->string('invoice_number')->nullable()->comment("发票唯一code");
                $table->dateTime('created_at')->comment("订单创建时间");
                $table->dateTime('updated_at')->comment("订单最近修改信息时间");
//                $table->timestamps();
                $table->index("order_sn");
                $table->index("buyer_id");
                $table->primary("order_sub_sn");
            });
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE order_sub AUTO_INCREMENT=1000");
        }

        /**
         * 订单详情表
         */
        if(!Schema::hasTable('order_detail')){
            Schema::create('order_detail', function (Blueprint $table) {
                $table->increments('order_detail_id')->comment("订单详情ID");
                $table->string('order_sn')->comment("订单编号");
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->string('product_number')->nullable()->comment("商品唯一code");
                $table->string('product_art_no')->comment("货号");
                $table->string('product_name')->comment("商品名称");
                $table->integer('product_cnt')->comment("购买数量")->default(0);
                $table->decimal('product_money')->comment("商品单价")->default(0);
//                $table->decimal('payment_money')->comment("实际支付金额")->default(0);
                $table->decimal('discount_money')->nullable()->comment("优惠金额")->default(0);
                $table->decimal('shipping_money')->nullable()->comment("运费金额")->default(0);
//                $table->decimal('le_gold_money')->comment("乐币抵扣金额")->default(0);
                $table->decimal('order_detail_growth')->nullable()->comment("订单可获得成长值")->default(0);
                $table->integer('order_detail_le_glod')->nullable()->comment("订单可获得乐币")->default(0);
                $table->string('sku_unique_code')->comment("sku属性组唯一code");
                $table->string('sku_code')->comment("sku编号");
                $table->string('product_sku_attr')->comment("商品sku属性【存json】");
                $table->dateTime('created_at')->comment("订单详情创建时间");
                $table->dateTime('updated_at')->comment("订单详情最近修改信息时间");
//                $table->timestamps();
                $table->index("order_sn");
                $table->index("order_sub_sn");
            });
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE order_detail AUTO_INCREMENT=1000");
        }

        /**
         * 发票信息表
         */
        if(!Schema::hasTable('order_invoice')){
            Schema::create('order_invoice', function (Blueprint $table) {
                $table->increments('order_invoice_id')->comment("订单发票ID");
                $table->string('order_sn')->comment("订单编号");
                $table->string('invoice_number')->comment("发票唯一code");
                $table->tinyInteger('invoice_type')->comment("发票类型【0电子普通1纸质普通】")->default(0);
                $table->string('invoice_title')->comment("发票抬头");
                $table->string('invoice_content')->comment("发票内容");
                $table->string('invoice_user_phone')->comment("收票人手机");
                $table->string('invoice_user_email')->nullable()->comment("收票人邮箱");
                $table->dateTime('created_at')->comment("发票信息创建时间");
                $table->dateTime('updated_at')->comment("发票信息最近修改信息时间");
//                $table->timestamps();
                $table->index("order_sn");
            });
        }

        /**
         * 发货单表
         */
        if(!Schema::hasTable('order_ship')){
            Schema::create('order_ship', function (Blueprint $table) {
                $table->increments('order_ship_sn')->comment("发货单号");
                $table->string('order_sn')->comment("订单编号");
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->string('shipping_sn')->comment("快递单号");
                $table->string('shipping_comp_code')->nullable()->comment("快递编号");
                $table->string('shipping_comp_name')->comment("快递公司名称");
                $table->integer('order_detail_id')->comment("订单详情ID");
                $table->integer('product_cnt')->comment("购买数量")->default(0);
                $table->dateTime('send_time')->comment("发货时间");
//                $table->integer('delivery_type')->comment("快递类型ID");
                $table->integer('seller_id')->comment("商家ID");
                $table->dateTime('created_at')->comment("发货单创建时间");
                $table->dateTime('updated_at')->comment("发货单最近修改信息时间");
//                $table->timestamps();
                $table->index("order_sn");
            });
        }

        /**
         * 退货单表
         */
        if(!Schema::hasTable('order_returns')){
            Schema::create('order_returns', function (Blueprint $table) {
                $table->string('order_return_sn')->comment("退货款编号");
                $table->string('order_sn')->comment("订单编号");
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->string('product_number')->nullable()->comment("商品唯一code");
                $table->integer('buyer_id')->comment("下单用户ID");
                $table->integer('seller_id')->comment("商家ID");
//                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0退款中1已退款，默认0】");
                $table->tinyInteger('return_goods_status')->nullable()->comment("退货状态【0退货中1已退货2拒绝，默认0】");
                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0退款中1已退款,默认0】");
                $table->integer('seller_address_id')->comment("商家收货地址ID");
//                $table->string('receive_province')->comment("收货省");
//                $table->string('receive_city')->comment("收货市");
//                $table->string('receive_area')->comment("收货区");
//                $table->string('receive_address')->comment("收货详细地址");
//                $table->string('receive_postal_code')->nullable()->comment("邮政编码");
//                $table->string('receive_name')->comment("收货人姓名");
//                $table->string('receive_phone')->comment("收货人手机号");
                $table->integer('coupon_id')->nullable()->comment("优惠券ID");
                $table->decimal('freight_money')->nullable()->comment("退货运费金额");
                $table->string('shipping_sn')->nullable()->comment("退货快递单号");
                $table->string('shipping_comp_name')->nullable()->comment("退货快递公司名称");
                $table->text('refuse_reason')->nullable()->comment("拒绝理由");
                $table->dateTime('del_time')->comment("审核时间");
                $table->dateTime('return_goods_time')->comment("退货时间");
                $table->dateTime('refund_time')->comment("退款时间");
                $table->dateTime('created_at')->comment("订单退货时间");
                $table->dateTime('updated_at')->comment("订单退货完成时间");
//                $table->timestamps();
                $table->index("order_sn");
                $table->primary("order_return_sn");
            });
        }

        /**
         * 退货单详情表
         */
        if(!Schema::hasTable('order_returns_detail')){
            Schema::create('order_returns_detail', function (Blueprint $table) {
                $table->increments('id')->comment("退货单详情ID");
                $table->string('order_return_sn')->comment("退货款编号");
                $table->string('order_sn')->comment("订单编号");
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->integer('buyer_id')->comment("下单用户ID");
                $table->string('product_number')->comment("商品唯一code");
                $table->string('product_name')->comment("商品名称");
                $table->integer('product_cnt')->comment("购买数量")->default(0);
                $table->decimal('product_money')->comment("商品单价")->default(0);
                $table->decimal('payment_money')->comment("实际支付金额")->default(0);
                $table->string('sku_code')->comment("sku编号");
                $table->string('sku_unique_code')->comment("sku属性组唯一code");
                $table->string('product_sku_attr')->comment("商品sku属性【存json】");
                $table->text('return_goods_reason')->nullable()->comment("退货原因");
                $table->text('return_goods_desr')->nullable()->comment("退货描述");
                $table->text('return_goods_img')->nullable()->comment("退货图片");
//                $table->timestamps();
                $table->index("order_return_sn");
                $table->index("order_sn");
            });
        }

        /**
         * 退款单表
         */
        if(!Schema::hasTable('order_refund')){
            Schema::create('order_refund', function (Blueprint $table) {
                $table->string('order_refund_sn')->comment("退款编号");
                $table->string('order_sn')->comment("订单编号");
                $table->string('order_sub_sn')->comment("子订单编号");
                $table->integer('buyer_id')->comment("退款用户ID");
//                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0退款中1已退款，默认0】");
                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0退款中1已退款】");
                $table->decimal('refund_money')->comment("退款金额");
                $table->string('pay_sn')->comment("微信支付订单号");
                $table->dateTime('created_at')->comment("订单退货时间");
                $table->dateTime('updated_at')->comment("订单退货完成时间");
//                $table->timestamps();
                $table->index("order_sn");
                $table->primary("order_refund_sn");
            });
        }

        /**
         * 充值单表
         */
        if(!Schema::hasTable('order_recharge')){
            Schema::create('order_recharge', function (Blueprint $table) {
                $table->string('order_recharge_sn')->comment("充值单号");
                $table->integer('buyer_id')->nullable()->comment("会员ID");
                $table->integer('company_id')->nullable()->comment("企业ID");
//                $table->tinyInteger('refund_status')->nullable()->comment("退款状态【0退款中1已退款，默认0】");
                $table->tinyInteger('payment_method')->nullable()->comment("支付方式【0微信支付】")->default(0);
                $table->decimal('money')->comment("充值金额")->default(0);
                $table->decimal('pay_price')->comment("实际支付金额")->default(0);
                $table->dateTime('pay_time')->nullable()->comment("支付时间");
                $table->string('pay_sn')->comment("微信支付订单号");
                $table->tinyInteger('pay_status')->nullable()->comment("充值状态【0充值失败1充值成功】");
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改时间");
//                $table->timestamps();
                $table->primary("order_recharge_sn");
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
        Schema::drop('order');
        Schema::drop('order_sub');
        Schema::drop('order_detail');
        Schema::drop('order_invoice');
        Schema::drop('order_ship');
        Schema::drop('order_returns');
        Schema::drop('order_returns_detail');
        Schema::drop('order_refund');
    }
}
