<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResponseHelper
 *
 * @author Administrator
 */
class ResponseHelper extends Response{
    public static function success($result=NULL){
        return parent::json($result, 200);
    }
    
    public static function error($message=NULL,$error=NULL,$code=NULL,$status){
        $result=[
            "message"=>$message,
            "error"=>$error,
            "code"=>$code,
        ];
        return parent::json($result,$status);
    }
}
