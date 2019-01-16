<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataBaseHelper
 *
 * @author Administrator
 */
class DataBaseHelper {

    
    public static function setPassword($password){
        return md5($password);
    }
    
    
    /**
     * 获取IP 地址
     * @return type
     */
    public static function getIp() {
        return Request::server('REMOTE_ADDR');
    }

    public static function arrayToXml($data, $xml = TRUE) {
        $xmls = $xml ? "<xml>" : "";
        foreach ($data as $key => $val) {
            if (is_numeric($val)) {
                $xmls.="<" . $key . ">" . $val . "</" . $key . ">";
            } elseif (is_array($val)) {
                $xmls.="<" . $key . ">";
                $xmls.=self::arrayToXml($val, FALSE);
                $xmls.="</" . $key . ">";
            } else {
                $xmls.="<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xmls.=$xml ? "</xml>" : "";
        return $xmls;
    }

    public static function xmlToArray($data) {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 将一个二维数组改错多维树形结构
     */
    public static function data2Tree($data, $k = ["data" => "id", "tree" => "v"], $pkey = "parent_id", $val = ["data" => "name", "tree" => "n"], $item = "s") {
        if (!$data) {
            return [];
        }
        if (is_object($data)) {
            $data = $data->toArray();
        }
        $treeBase = [];
        foreach ($data as $value) {
            $treeBase[$value[$k["data"]]] = $value;
            $treeBase[$value[$k["data"]]][$k["tree"]] = $value[$k["data"]];
            $treeBase[$value[$k["data"]]][$val["tree"]] = $value[$val["data"]];
            $treeBase[$value[$k["data"]]]["pid"] = array_get($value, $pkey);
            $treeBase[$value[$k["data"]]][$item] = [];
        }
        foreach ($treeBase as $key => &$value) {
            if (array_get($value, "pid")) {
                $treeBase[$value['pid']][$item][] = &$value;
            }
            $treeBase[$key] = &$value;
        }
        $tree = [];
        foreach ($treeBase as $t) {
            if (!array_get($t, "pid")) {
                $tree[] = $t;
            }
        }
        return $tree;
    }

    /**
     * 将一个树形结构还原回二维数组
     */
    public static function tree2Data($tree, $item = "children", $key = "id", $parentKey = "parent_id", $pid = NULL) {
        $list = [];
        foreach ($tree as $value) {
            $data = isset($value[$item]) ? $value[$item] : [];
            unset($value[$item]);
            $value[$parentKey] = $pid;
            $list[] = $value;
            if ($data) {
                $result = self::tree2Data($data, $item, $key, $parentKey, $value[$key]);
                $list = array_merge($list, $result);
            }
        }
        return $list;
    }

    /**
     * 转换为标准手机格式
     * @param type $mobile
     * @return []  [省,市,区]
     */
    public static function toMobile($mobile) {
        return str_replace([" ", "86+", "+86", "-"], ["", "", "", ""], $mobile);
    }

    public static function rand($len = 16, $type = "all") {
        $sChar = ["q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "l", "k", "j", "h", "g", "f", "d", "s", "a", "z", "x", "c", "v", "b", "n", "m"];
        $bChar = ["Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "L", "K", "J", "H", "G", "F", "D", "S", "A", "Z", "X", "C", "V", "B", "N", "M"];
        $int = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        $char = [];
        switch ($type) {
            case "schar":
                $char = array_merge($char, $sChar);
                break;
            case "bchar":
                $char = array_merge($char, $bChar);
                break;
            case "int":
                $char = array_merge($char, $int);
                break;
            default :
                $char = array_merge($char, $sChar);
                $char = array_merge($char, $bChar);
                $char = array_merge($char, $int);
                break;
        }
        $str = "";
        $keys = [];
        for ($i = 0; $i < $len; $i++) {
            $keys[] = array_rand($char);
        }
        foreach ($keys as $key) {
            $str.=$char[$key];
        }
        return $str;
    }

    public static function getFromUrl() {
        return Input::server("HTTP_REFERER");
    }

    public static function array_depth($array) {
        if (!is_array($array))
            return 0;
        $max_depth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = self::array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }
        return $max_depth;
    }

    /**
     * 获取指定月份天数
     * @param type $date
     */
    public static function getMonthDays($date) {
        $timestamp = strtotime($date);
        if (function_exists("cal_days_in_month")) {
            return cal_days_in_month(CAL_GREGORIAN, date("m", $timestamp), date("Y", $timestamp));
        } else {
            return date("t", strtotime($date));
        }
    }

    public static function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public static function getRand($option) {
        $data = [];
        foreach ($option as $key => $value) {
            for ($i = 0; $i < $value; $i++) {
                $data[] = $key;
            }
        }
        $key = array_rand($data);
        return $data[$key];
    }

    public static function getContinue($arr) {
        $continue = [];
        $before = 0;
        $k = 0;
        foreach ($arr as $value) {
            if (($before + 1) != $value) {
                $k++;
            }
            if (!isset($continue[$k])) {
                $continue[$k] = 0;
            }
            $continue[$k] ++;
            $before = $value;
        }
        return $continue;
    }
    

    /**
     * 属性转换
     * @param type $attribute
     * @return type
     */
    public static function attrCombination($attribute) {
        $attribute=array_values($attribute);
        if (count($attribute) === 1) {
            $result = $attribute[0];
        } else {
            //保存结果
            $result = [];
            //循环遍历集合数据
            for ($i = 0, $count = count($attribute); $i < $count - 1; $i++) {
                // 初始化
                if ($i == 0) {
                    $result = $attribute[$i];
                }
                // 保存临时数据
                $tmp = [];
                // 结果与下一个集合计算笛卡尔积
                foreach ($result as $res) {
                    foreach ($attribute[$i + 1] as $set) {
                        $tmp[] = $res ."|". $set;
                    }
                }
                // 将笛卡尔积写入结果
                $result = $tmp;
            }
            $list=[];
        }
        foreach ($result as $value){
            $list[]=  explode("|", $value);
        }
        return $list;
    }
    
    /**
     * 数组转对象
     * @param type $arr [{"key":"1","value":2},{"key":"a","value":3}]
     * @param type $value
     * @param type $key
     */
    public static function Arr2Map($arr,$value,$key=NULL){
        $data=[];
        foreach ($arr as $arrData){
            $dataValue=array_get($arrData, $value);
            $dataKey=NULL;
            if($key){
                $dataKey=array_get($arrData, $key);
            }
            if($dataKey){
                $data[$dataKey]=$dataValue;
            }else{
                $data[]=$dataValue;
            }
        }
        return $data;
    }
    
    /**
     * 手机号码隐私化
     * @param type $phone
     */
    public static function phoneSecret($phone){
        return substr($phone,0,3)."****".substr($phone,-4);
    }
    
    public static function getBirthdayByIdCard($idCard){
        if(!ValidateHelper::isIdCard($idCard)){
            return NULL;
        }
        $birthday=substr($idCard,6,8);
        $birthday=date("Y-m-d",strtotime($birthday));
        return $birthday;
    }
    
    public static function getAge($date){
        if(!$date){
            return NULL;
        }
        $year=date("Y", strtotime($date));
        $nowYear=date("Y");
        $age=$nowYear-$year;
        if($age<0){
            return 0;
        }
        return $age;
    }
    
    /**
     * 根据身份证判断是否是男性
     * @param type $idCard
     * @return boolean
     */
    public static function checkManByIdCard($idCard){
        if(!ValidateHelper::isIdCard($idCard)){
            return NULL;
        }
        $gender=substr($idCard,16,1);
        if($gender%2){
            return FALSE;
        }
        return TRUE;
    }
    
}
