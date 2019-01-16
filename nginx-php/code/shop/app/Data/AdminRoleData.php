<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Data;

/**
 * 管理员数据
 *
 * @author Administrator
 */
class AdminRoleData {
    private static function key(){
        return "role";
    }

    public static function info($code){
        $result=self::all();
        if($result->toArray()){
            foreach ($result as $roleModel) {
                if($roleModel->code==$code){
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
