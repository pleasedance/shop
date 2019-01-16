<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValidateHelper
 *
 * @author Administrator
 */
class ValidateHelper {
    
    
    /*************************** 校验身份证开始 *************************************** */

    //验证身份证是否有效
    public static function isIdCard($IDCard) {
        if (strlen($IDCard) == 18) {
            return self::check18IDCard($IDCard);
        } elseif ((strlen($IDCard) == 15)) {
            $IDCard = convertIDCard15to18($IDCard);
            return self::check18IDCard($IDCard);
        } else {
            return false;
        }
    }

    //计算身份证的最后一位验证码,根据国家标准GB 11643-1999
    private static function calcIDCardCode($IDCardBody) {
        if (strlen($IDCardBody) != 17) {
            return false;
        }
        //加权因子 
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值 
        $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;

        for ($i = 0; $i < strlen($IDCardBody); $i++) {
            $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
        }

        return $code[$checksum % 11];
    }

    // 将15位身份证升级到18位 
    private static function convertIDCard15to18($IDCard) {
        if (strlen($IDCard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
            if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
            } else {
                $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
            }
        }
        $IDCard = $IDCard . self::calcIDCardCode($IDCard);
        return $IDCard;
    }

    // 18位身份证校验码有效性检查 
    private static function check18IDCard($IDCard) {
        if (strlen($IDCard) != 18) {
            return false;
        }

        $IDCardBody = substr($IDCard, 0, 17); //身份证主体
        $birthYear = substr($IDCard, 6, 2);
        if (!in_array($birthYear, ["19", "20"])) {
            return false;
        }
        $birthMon = substr($IDCard, 10, 2);
        if ($birthMon > 12) {
            return false;
        }
        $birthDay = substr($IDCard, 12, 2);
        if ($birthMon > 31) {
            return false;
        }
        $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

        if (self::calcIDCardCode($IDCardBody) != $IDCardCode) {
            return false;
        } else {
            return true;
        }
    }

    /*************************** 校验身份证结束 *************************************** */
    
    public static function isChinese($content) {
        if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $content) > 0) {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 是否是手机号
     * @param type $phone
     * @return boolean
     */
    public static function isMobile($phone){
        if(preg_match("/^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/",$phone)){
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 第一个是否首字母
     * @param type $string
     * @return boolean
     */
    public static function firstLetter($string){
        if(preg_match("/^[a-zA-Z].*$/",$string)){
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 是否只有字母和数字组成
     * @param type $string
     * @return boolean
     */
    public static function letterNumber($string){
        if(preg_match("/^[a-zA-Z0-9]*$/",$string)){
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 密码规则验证
     * @param type $string
     * @return boolean
     */
    public static function isPwd($string){
        if(preg_match("/^[0-9a-zA-z_\.]{6,12}$/", $string)){
            return TRUE;
        }
        return FALSE;
    }
    
    public static function isNumber($data){
        if(is_numeric($data) && !strpos($data, '.')){
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 判断参数是否为正数
     * @param  mixed  $data 待验证参数
     * @return boolean      是否是正数
     */
    public static function isPositive($data) {
        if(!self::isNumber($data))
            return false;
        if($data <= 0)
            return false;
        return true;
    }
    
    /**
     * 判断是否非负整数
     * @param type $data
     * @return boolean
     */
    public static function isNonnegative($data){
        if(!self::isNumber($data))
            return false;
        if($data < 0)
            return false;
        return true;
    }

    /**
     * 判断是否为空
     * @param  mixed   $data 待验证参数
     * @return boolean       是否为空
     */
    public static function isEmpty($data) {
        if(is_null($data))
            return true;
        if(is_string($data) && $data === "")
            return true;
        if(is_array($data) && count($data) === 0)
            return true;
        if(is_numeric($data) && $data == 0)
            return true;
        return false;
    }
    
    /**
     * 判断是否为有效url
     * @param  string   $url 待验证参数
     * @return boolean       是否有效
     */
    public static function isUrl($url) {
        if(filter_var($url, FILTER_VALIDATE_URL)){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 判断是否金额
     * @param type $money
     * @return boolean
     */
    public static function isMoney($money) {
        if ($money >= 0 && (string) $money == (string) round($money, 2)) {
            return TRUE;
        }
        return FALSE;
    }
}
