<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 17:32
 */

namespace App\Models;


class SellerAddressModel extends BaseModel
{
    protected $table = "seller_address";
    public $timestamps = false;

    const defaultActive = 1;//是默认地址
    const defaultInactive = 0;//不是默认地址

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}