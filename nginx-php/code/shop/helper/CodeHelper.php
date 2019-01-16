<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CodeHelper
 *
 * @author Administrator
 */
class CodeHelper {
    public static function setCompanyOrderCode(){
        $code=date("ym").DataBaseHelper::rand(8,"int");
        $exsit= App\Models\CompanyOrderModel::where("code",$code)->first();
        if($exsit){
            return self::setCompanyOrderCode();
        }
        return $code;
    }
    
}
