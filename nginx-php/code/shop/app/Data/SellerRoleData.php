<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 14:48
 */

namespace App\Data;


class SellerRoleData
{
    private static function key(){
        return "role";
    }

    public static function info($code){
        $result=self::all();
        if($result->toArray()){
            foreach ($result as $roleModel) {
                if($roleModel->role_name==$code){
                    return $roleModel;
                }
            }
        }
        return NULL;
    }

    public static function all(){
        $result= \RedisDataHelper::fetch(self::key());
        if(!$result){
            $result=\App\Models\SellerRoleModel::get();
            if($result->toArray()){
                \RedisDataHelper::save(self::key(), $result);
            }
        }
        return $result;
    }

    public static function flash(){
        \RedisDataHelper::delete(self::key());
    }
}