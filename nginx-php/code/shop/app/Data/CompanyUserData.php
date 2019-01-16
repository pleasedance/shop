<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 14:14
 */

namespace App\Data;


class CompanyUserData
{
    private static function key($id){
        return "company_user_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\CompanyUserModel::where("sys_user_id",$id)->with("company")->first();
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