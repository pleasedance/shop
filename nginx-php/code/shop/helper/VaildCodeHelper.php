<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 验证码辅助类
 *
 * @author Administrator
 */
class VaildCodeHelper {
    
    /********************* 登录验证码开始 ****************************/
    /**
     * 登录验证码key
     * @param type $mobile
     * @return type
     */
    public static function loginKey($mobile)
    {
        return "login_vaild_".$mobile;
    }
    
    /**
     * 登录验证码
     * @param type $mobile 手机号
     * @param type $timeout 超时时间
     * @param type $cd CD时间
     * @throws AppException
     */
    public static function sendLogin($mobile,$timeout=600,$cd=60){
        $code=self::getLogin($mobile);
        if($code){
            $ttl=self::loginTll($mobile);
            if($timeout-$ttl<$cd){
                throw new App\Exceptions\AppException("验证码发送过于频繁");
            }
        }else{
            $code= DataBaseHelper::rand(4, "int");
        }
        $server = new \App\Service\Message\PhoneService();
        $server->setTmp(34445);
        $server->setParam([$code]);
        $server->setMobile($mobile);
        $server->setSign(45581);
        $server->save();
        RedisTemporaryHelper::save(self::loginKey($mobile), $code, $timeout);
    }
    
    /**
     * 获取登录验证码
     */
    public static function getLogin($mobile){
        return RedisTemporaryHelper::fetch(self::loginKey($mobile));
    }
    
    /**
     * 删除验证码
     * @param type $phone
     * @return type
     */
    public static function delLogin($mobile){
        return RedisTemporaryHelper::delete(self::loginKey($mobile));
    }
    
    /**
     * 获取登录验证码发送时间间隔
     */
    public static function loginTll($mobile){
        return RedisTemporaryHelper::ttl(self::loginKey($mobile));
    }
    /********************* 登录验证码结束 ****************************/
    
}
