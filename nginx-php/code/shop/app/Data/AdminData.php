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
class AdminData {
    /******************* 根据管理员id获取管理员对象 START ******************/
    
    private static function key($id){
        return "admin_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\AdminModel::find($id);
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
