<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3
 * Time: 15:39
 */

namespace App\Data;


class WxAccessTokenData
{
    private static function key(){
        return "access_token";
    }

    public static function info(){
        $access_token = \RedisDataHelper::fetch(self::key());
        return $access_token;
    }

    public static function set($data,$time){
        \RedisDataHelper::save(self::key(),$data,$time);
        return self::info(self::key());
    }

    public static function flash(){
        \RedisDataHelper::delete(self::key());
    }
}