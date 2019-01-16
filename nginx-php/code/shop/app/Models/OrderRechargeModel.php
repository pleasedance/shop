<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14
 * Time: 16:46
 */

namespace App\Models;


class OrderRechargeModel extends BaseModel
{
    protected $table = "order_recharge";
    protected $primaryKey = 'order_recharge_sn';
    public $incrementing = false;//非递增或者非数字的主键
    protected $keyType = "string";//主键不是一个整数

    const wxMethod = 0;//微信支付

    const success = 1;//充值成功
    const fail = 0;//充值失败
}