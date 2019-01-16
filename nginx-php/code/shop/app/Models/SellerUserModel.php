<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 15:26
 */

namespace App\Models;


class SellerUserModel extends BaseModel
{
    protected $table = "seller_user";
    protected $primaryKey = 'seller_user_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用

    const roleRoot="root";      //超级管理员

    const sexMan = 0;//男
    const sexWoman = 1;//女
    const sexSecrecy = 2;//保密

//    public function scopeMan($query){
//        return $query->where("sex", SellerUserModel::sexMan);
//    }
}