<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 14:56
 */

namespace App\Models;


class MoneyLogModel extends BaseModel
{
    protected $table = "money_log";

    const statusRecharge = 1;//充值
    const statusConsume = 0;//消费

    const companyRecharge = 0;//企业给用户充值
    const userRecharge = 1;//用户充值
    const cpTocpRecharge = 2;//企业给企业充值

    const order = 0;//主订单
    const orderSub = 1;//子订单
    const orderRecharge = 2;//充值单号

    //禁止update_at
    const UPDATED_AT = NULL;

    public function company()
    {
        return $this->belongsTo("App\Models\CompanyModel","company_id","company_id");
    }

    public function buyer()
    {
        return $this->belongsTo("App\Models\BuyerModel","buyer_id","buyer_id");
    }
}