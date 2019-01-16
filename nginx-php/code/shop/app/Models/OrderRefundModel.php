<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 12:56
 */

namespace App\Models;


class OrderRefundModel extends BaseModel
{
    protected $table = "order_refund";
    protected $primaryKey = 'order_refund_sn';
    public $incrementing = false;//非递增或者非数字的主键
    protected $keyType = "string";//主键不是一个整数

    const refunding = 0;//退款中
    const refunded = 1;//已退款

    public function order(){
        return $this->belongsTo("App\Models\OrderModel","order_sn","order_sn");
    }
}