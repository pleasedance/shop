<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 10:17
 */

namespace App\Data;


class SellerUserData
{
    /******************* 根据管理员id获取管理员对象 START ******************/

    private static function key($id){
        return "seller_user_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\SellerUserModel::where("seller_user_id",$id)->first();
            if($model){
                \RedisDataHelper::save(self::key($id), $model);
            }
        }
        return $model;
    }

    public static function flash($id){
        \RedisDataHelper::delete(self::key($id));
    }
    /******************* 根据管理员id获取管理员对象 END ******************/
}