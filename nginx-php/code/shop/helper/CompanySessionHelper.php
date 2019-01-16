<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanySessionHelper
 *
 * @author Administrator
 */
class CompanySessionHelper  {
    
    const cookieKey="CompanyFlowToken";

    public static function set(App\Models\CompanyUserModel $model){
        self::eliminate($model);
        $key="companyflow_a_".$model->sys_user_id."_".str_random(32);
        RedisSessionHelper::save($key, $model->sys_user_id,3600*24);
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
        self::$get = \App\Data\CompanyUserData::info($id);
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
    public static function eliminate(App\Models\CompanyUserModel $model){
        $key="companyflow_a_".$model->sys_user_id."_*";
        $list=RedisSessionHelper::keys($key);
        if($list){
            foreach ($list as $value){
                RedisSessionHelper::delete($value);
            }
        }
    }

//    public static function resuser()

}
