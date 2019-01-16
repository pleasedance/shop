<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendMessageHelper
 *
 * @author Administrator
 */
class SendMessageHelper {

    public static function send($phone,$tmp,$param){
        if(!Config::get("sms.tmp.".$tmp)){
            throw new ServerExp("短信模板不存在！");
        }
        $model=new Jid\PhoneMessageModel();
        $model->phone=$phone;
        $model->param=$param;
        $model->tmp=$tmp;
        $model->save();
    }
    
    public static function sendMessage($phone,$message){
        $params=array(
            "SpCode"=>'216485',
            "LoginName"=>"hz_jmsc",
            "Password"=>"Jstar@000000",
            "MessageContent"=>iconv('UTF-8','GB2312', $message),
            "UserNumber"=>$phone,
            "SerialNumber"=>'',
            "ScheduleTime"=>"",
            "f"=>"1"
        );
        return self::getParam(SocketHelper::request("http://sms.api.ums86.com:8888/sms/Api/Send.do", $params));
    }
    
}
