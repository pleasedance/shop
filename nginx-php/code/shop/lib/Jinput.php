<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Support\Facades\Input;
/**
 * Description of Jinput
 *
 * @author Administrator
 */
class Jinput {
    
    /**
     * 获取表单输入信息
     * @param type $field
     * @param type $default
     * @return type
     */
    public static function get($field,$default=NULL){
        if(is_array($default)){
            $data=Input::get($field,$default);
            if(!is_array($data)){
                return $default;
            }
            return $data;
        }else{
            $data=Input::get($field,$default);
            if(is_array($data)){
                return $default;
            }
            return $data;
        }
    }
    
    /**
     * 安全搜索 避免批量搜索
     */
    public static function safeSearch($str){
        return str_replace("_", "\_", $str);
    }
}
