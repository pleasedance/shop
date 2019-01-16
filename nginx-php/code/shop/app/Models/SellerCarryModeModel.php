<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 13:22
 */

namespace App\Models;


class SellerCarryModeModel extends BaseModel
{
    protected $table = "seller_carry_mode";
    protected $primaryKey = 'transfer_id';

    const defaultActive = 1;//是默认地址
    const defaultInactive = 0;//不是默认地址

    const expressTransfer = 0;//快递
    const emsTransfer = 1;//ems
    const PlainTransfer = 2;//平邮
}