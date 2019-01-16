<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:39
 */

namespace App\Data;


class SystemUserData
{
    private static function key($id){
        return "system_user_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\SystemUserModel::where("id",$id)->first();
            if($model){
                \RedisDataHelper::save(self::key($id), $model);
            }
        }
        return $model;
    }

    public static function flash($id){
        \RedisDataHelper::delete(self::key($id));
    }
}