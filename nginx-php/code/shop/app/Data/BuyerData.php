<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14
 * Time: 13:45
 */

namespace App\Data;


class BuyerData
{
    private static function key($id){
        return "buyer_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\BuyerModel::where("buyer_id",$id)->first();
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