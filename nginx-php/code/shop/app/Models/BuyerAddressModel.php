<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28
 * Time: 15:17
 */

namespace App\Models;


class BuyerAddressModel extends BaseModel
{
    protected $table = "buyer_address";
    public $timestamps = false;

    const defaultActive = 1;//是默认地址
    const defaultInactive = 0;//不是默认地址

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function getDefaultAttribute()
    {
        return ($this->attributes['is_default']==0)?"否":"是";
    }
}