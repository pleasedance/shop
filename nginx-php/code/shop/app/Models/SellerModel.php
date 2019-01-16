<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 14:27
 */

namespace App\Models;


class SellerModel extends BaseModel
{
    protected $table = "seller";
    protected $primaryKey = 'seller_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用

    public function user(){
        return $this->hasOne("App\Models\SellerUserModel","seller_id","seller_id");
    }
}