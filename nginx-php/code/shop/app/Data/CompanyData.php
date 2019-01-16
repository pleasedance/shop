<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Data;

/**
 * Description of CompanyData
 *
 * @author Administrator
 */
class CompanyData {
    
    private static function key($id){
        return "company_".$id;
    }

    public static function info($id){
        $model= \RedisDataHelper::fetch(self::key($id));
        if(!$model){
            $model= \App\Models\CompanyModel::find($id);
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
