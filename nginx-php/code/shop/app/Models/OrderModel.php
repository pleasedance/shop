<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 13:12
 */

namespace App\Models;


class OrderModel extends BaseModel
{
    protected $table = "order";
    protected $primaryKey = 'order_sn';
    public $incrementing = false;//非递增或者非数字的主键
    protected $keyType = "string";//主键不是一个整数

    const wxPay = 0;//微信支付
    const balancePay = 1;//余额支付
//    const aliPay = 0;//支付宝
//    const wxPay = 1;//微信
//    const onlinePay = 2;//网银

    const appSource = 0;//APP
    const wapSource = 1;//wap

    const statusActive = 1;//有效
    const statusInactive = 0;//无效
    const statusDel = 2;//删除

    const statusSend = 1;//已发货
    const statusNoSend = 0;//未发货

    const statusPay = 1;//已支付
    const statusNoPay = 0;//未支付

    const isReceipt = 1;//已收货
    const noReceipt = 0;//未收货

    const isEvaluation = 1;//已评价
    const noEvaluation = 0;//未评价

    const statusRefund = 1;//已退款
    const statusNoRefund = 0;//未退款

    const statusReturnGoods = 1;//已退货
    const statusNoReturnGoods = 0;//未退货
    const statusApplyReturnGoods = 2;//申请中

    const isDeal = 1;//已处理
    const noDeal = 0;//未处理
    const refuseDeal = 2;//拒绝

    public function orderDetail(){
        return $this->hasMany("App\Models\OrderDetailModel","order_sn","order_sn");
    }

    public function orderSub(){
        return $this->hasMany("App\Models\OrderSubModel","order_sn","order_sn");
    }

    /*
    public function setPayMethodAttribute($value){
        if( $value == '支付宝' ){
            $this->attributes['payment_method'] = self::aliPay;
        }
        if( $value == '微信' ){
            $this->attributes['payment_method'] = self::wxPay;
        }
        if( $value == '网银' ){
            $this->attributes['payment_method'] = self::onlinePay;
        }
    }

    public function setSourceAttribute($value){
        if( $value == 'APP' ){
            $this->attributes['order_source'] = self::statusSend;
        }
        if( $value == 'wap' ){
            $this->attributes['order_source'] = self::statusNoSend;
        }
    }

    public function setOrderStatusAttribute($value){
        if( $value == '有效' ){
            $this->attributes['order_status'] = self::statusActive;
        }
        if( $value == '无效' ){
            $this->attributes['order_status'] = self::statusInactive;
        }
    }

    public function setSendAttribute($value){
        if( $value == '已发货' ){
            $this->attributes['send_status'] = self::appSource;
        }
        if( $value == '未发货' ){
            $this->attributes['send_status'] = self::wapSource;
        }
    }

    public function setPayStatusAttribute($value){
        if( $value == '已支付' ){
            $this->attributes['pay_status'] = self::statusPay;
        }
        if( $value == '未支付' ){
            $this->attributes['pay_status'] = self::statusNoPay;
        }
    }

    public function setRefundStatusAttribute($value){
        if( $value == '已退款' ){
            $this->attributes['refund_status'] = self::statusRefund;
        }
        if( $value == '未退款' ){
            $this->attributes['refund_status'] = self::statusNoRefund;
        }
    }

    public function setReturnStatusAttribute($value){
        if( $value == '已退货' ){
            $this->attributes['return_goods_status'] = self::statusReturnGoods;
        }
        if( $value == '未退货' ){
            $this->attributes['return_goods_status'] = self::statusNoReturnGoods;
        }
    }*/
}