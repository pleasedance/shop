<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SystemHelper 
{
    
    public static $system='system';

   //设置Value
    public static function setValue($model){
            switch ($model->code){
                case \Jstar\SystemModel::$codeWxCustomerReplay:
                case \Jstar\SystemModel::$codeFreeShippingPrice:
                case \Jstar\SystemModel::$codeGroupAdWare:
                case \Jstar\SystemModel::$codeNewAdWare:
                case \Jstar\SystemModel::$codeReturnAdWare:
                case \Jstar\SystemModel::$codeBindingPhone:
                case \Jstar\SystemModel::$codeOrderPageNotice:
                case \Jstar\SystemModel::$codeRaiderAdWare:
                case \Jstar\SystemModel::$codeSpecialSaleAdWare:
                case \Jstar\SystemModel::$codeUpdateLog:
                case \Jstar\SystemModel::$codeOrderStrikeGoldBag:
                case \Jstar\SystemModel::$codeSignAdWare:
                case \Jstar\SystemModel::$codeShareBind:
                    $result = $model->value;
                    break;
                case \Jstar\SystemModel::$codeCouponComment:
                case \Jstar\SystemModel::$codeUserAttribute:
                case \Jstar\SystemModel::$codeCustomerServiceKeyWord:
                case \Jstar\SystemModel::$codeCouponTreeBarrage;
                    $result = array_filter(explode("\n", $model->value));
                    break;
                case \Jstar\SystemModel::$codeErpStock:
                case \Jstar\SystemModel::$codeNewGiftBagCoupon:
                case \Jstar\SystemModel::$codeGoldBagBanner:
                case \Jstar\SystemModel::$codeWeixinFollowReplay:
                case \Jstar\SystemModel::$codeMainTopic:
                    $result = $model->value ? json_decode($model->value,TRUE) : [];
                    break;
                case \Jstar\SystemModel::$codeMallHotTags:
                case \Jstar\SystemModel::$codePreSearch:
                    $result = explode(",", $model->value);
                    break;
                default:
                    $result = '';
                    break;
            }
            \RedisTemporaryHelper::hSet(self::$system, $model->code, $result);
            return $result;
    }
    //获取Value
    public static function getValue($code){
        $result = \RedisTemporaryHelper::hGet(self::$system, $code);
        if(!$result){
            $item = \Jstar\SystemModel::find($code);
            if($item){
                $result = self::setValue($item);
            }
        }
        return $result;
    }
    
    
}
