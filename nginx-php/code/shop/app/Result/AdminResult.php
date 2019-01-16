<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Result;
/**
 * Description of AdminResult
 *
 * @author Administrator
 */
class AdminResult {
    
    public static function getShowName(\App\Models\AdminModel $model){
        return $model->username ? $model->username : $model->mobile;
    }
    
    
    public static function info(\App\Models\AdminModel $model){
        return [
            "id"=>$model->id,
            "showname"=>self::getShowName($model)
        ];
    }
    
    
    
}
