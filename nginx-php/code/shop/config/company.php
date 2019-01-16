<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    "domain"=>"cp.itcitylife.com",
    "api"=>[
        "url"=>"http://cp.itcitylife.com/api/",
    ],
    "wxpay"=>"https://api.mch.weixin.qq.com/pay/unifiedorder",//微信支付api请求地址
    "wxpaycallback"=>"https://shop.migee.net/api/paycallback",//微信支付api请求回调
    "wxrechargecallback"=>"https://shop.migee.net/api/rechargecallback",//微信充值api请求回调
    "wxPayRefundBack"=>"https://shop.migee.net/api/payrefundcallback",//微信充值api请求回调
    "wxPayReturnGoodsBack"=>"https://shop.migee.net/api/payreturngoodscallback",//微信充值api请求回调
    "wxtradetype"=>[
        "JSAPI"=>"JSAPI",//小程序支付
        "NATIVE"=>"NATIVE",//Native支付
        "APP"=>"APP",//app支付
        "MWEB"=>"MWEB",//H5支付
        "MICROPAY"=>"MICROPAY",//付款码支付
    ],
    "login"=>"https://api.weixin.qq.com/sns/jscode2session",//登陆
    "appid"=>"wxe232fc2fbbdfbccd",//wxcff20e7ba2197f11//wxe232fc2fbbdfbccd
    "mch_id"=>"1523844011",//1504541691//1523844011
    "appsecret"=>"11e52294fd7883d20c5cfb66162cc417",//66e281fb6b37ee1717b2d9595725ff56//11e52294fd7883d20c5cfb66162cc417
    "key"=>"c0397089d77196f7cdfa4bde0f47939a",//ba5890eac4659d1a55002cd267f1c406//c0397089d77196f7cdfa4bde0f47939a
    "getAccessToken"=>"https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET",//获取accesstoken
    "getWXACodeUnlimit"=>"https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN",//生成小程序码
    "seedTempMeg"=>"https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN",//小程序发送模板消息
    "payRefund"=>"https://api.mch.weixin.qq.com/secapi/pay/refund",//退款
];