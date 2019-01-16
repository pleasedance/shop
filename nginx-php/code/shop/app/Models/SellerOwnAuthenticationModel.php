<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 15:50
 */

namespace App\Models;


class SellerOwnAuthenticationModel extends BaseModel
{
    protected $table = "seller_own_authentication";

    public function role(){
        return $this->hasOne("App\Models\SellerRoleModel","role_id","role_id");
//        return $this->belongsToMany("App\Models\SellerRoleModel","seller_role","role_id","role_id");
    }

    public function user(){
        return $this->hasOne("App\Models\SellerUserModel","seller_user_id","seller_user_id");
//        return $this->belongsToMany("App\Models\SellerUserModel","seller_user","seller_user_id","seller_user_id");
    }

    public function auth(){
//        return $this->hasMany("App\Models\SellerAuthenticationModel","authc_id","authc_id");
        return $this->belongsToMany("App\Models\SellerAuthenticationModel","seller_authentication","authc_id","authc_id");
    }
}