<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 16:03
 */

namespace App\Models;


class SellerRoleModel extends BaseModel
{
    protected $table = "seller_role";
    protected $primaryKey = 'role_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function user(){
        return $this->hasOne("App\Models\SellerUserModel","role_id","role_id");
//        return $this->belongsToMany("App\Models\SellerUserModel","seller_user","seller_user_id","seller_user_id");
    }

    public function auth(){
        return $this->hasMany("App\Models\SellerAuthenticationModel","role_id","role_id");
    }
}