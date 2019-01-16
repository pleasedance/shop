<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Phone
 *
 * @author Administrator
 */
class PhoneHelper {
    
    
    public static function send(App\Models\PhoneMessageModel $phoneMessageModel){
        $default=Config::get("sms.default");
        switch ($default) {
            case "feige":
                $result=with(new \Feige\Send(Config::get("sms.feige.account"), Config::get("sms.feige.pwd")))
                    ->setTmp($phoneMessageModel->tmp_id,$phoneMessageModel->param)
                    ->setSign($phoneMessageModel->sign)
                    ->setMobile($phoneMessageModel->mobile)
                    ->go();
                $server=new App\Service\Message\PhoneService($phoneMessageModel);
                if(!$result || array_get($result,"Code")){
                    $server->fail($result);
                }else{
                    $server->success($result);
                }
                break;

            default:
                break;
        }
    }
    
}
