<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
namespace CompanySdk;

/**
 * Description of Base
 *
 * @author 唐锦龙
 */
 
class CompanySdkBase {
    
    
    protected $route;      //路由
    protected $param=[];      //参数
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
        return \Config::get("company.api.url").$this->route;
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
            $ret=$api->getRet();
            throw new \App\Exceptions\AppException(array_get($ret,"message","接口请求失败"));
        }
        $ret=$api->getRet();
        return $ret;
    }
    
    
    
}
