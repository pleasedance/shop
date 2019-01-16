<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:36
 */

class SystemSessionHelper
{
    const cookieKey="systemUserFlowToken";

    public static function set(App\Models\SystemUserModel $model){
        self::eliminate($model);
        $key="system_userflow_a_".$model->id."_".str_random(32);
        RedisSessionHelper::save($key, $model->id,3600*24);
        self::$get=$model;
        return $key;
    }

    private static $get;
    public static function get(){
        if(self::$get){
            return self::$get;
        }
        $token = CookieHelper::get(self::cookieKey);
        $id = RedisSessionHelper::fetch($token);
        if(!$id){
            return NULL;
        }
        self::$get = \App\Data\SystemUserData::info($id);
        self::keep();
        return self::$get;
    }

    public static function forget(){
        $token = CookieHelper::get(self::cookieKey);
        RedisSessionHelper::delete($token);
        CookieHelper::forget(self::cookieKey);
    }


    public static function keep($data=NULL){
        $token = CookieHelper::get(self::cookieKey);
        if(!$data){
            $data=RedisSessionHelper::fetch($token);
        }
        if($data){
            if($token){
                RedisSessionHelper::save($token, $data,3600*24);
            }
        }
    }

    /**
     * 将某个用户踢下线
     * @param type $model
     */
    public static function eliminate(App\Models\SystemUserModel $model){
        $key="system_userflow_a_".$model->id."_*";
        $list=RedisSessionHelper::keys($key);
        if($list){
            foreach ($list as $value){
                RedisSessionHelper::delete($value);
            }
        }
    }
}