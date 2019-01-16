<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RiskManagement;

/**
 * Description of Base
 *
 * @author Administrator
 */
class Base {
    
    const baseUrl="http://collect.jinxfu.com/";
//    const baseUrl="http://192.168.0.166:8080/";
    
    
    protected $route;      //路由
    protected $param=[
        "key"=>"33333098f6bcd4621d373cade4e832627b4f6"
    ];      //参数
    protected $header=[];     //头信息
    
    protected $method=\JSocket::methodGet;


    public function setParam($param){
        foreach ($param as $key=>$value){
            $this->param[$key]=$value;
        }
        return $this;
    }
    
    public function setHeader($header){
        $this->header=$header;
        return $this;
    }
    
    
    private function getUrl(){
        return self::baseUrl.$this->route;
    }
    


    public function run(){
        $api=new \JSocket();
        $api->setUrl($this->getUrl())->setMethod($this->method);
        foreach ($this->param as $key=>$value){
            $api->setParam($key, $value);
        }
        $api->exe();
        $httpCode=$api->getHttpCode();
        if($httpCode!=200){
            throw new \App\Exceptions\AppException("风控数据请求失败");
        }
        $ret=$api->getRet();
        if(array_get($ret, "code")=="SUCCESS"){
            return array_get($ret, "data");
        }
        return NULL;
    }
    
    
    
}
