<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Feige;

/**
 * 发送飞鸽短信
 * @author Administrator
 */
class Send {
    
    private $param=[];
    
    public function __construct($account,$pwd) {
        $this->param["Account"]=$account;
        $this->param["Pwd"]=$pwd;
        return $this;
    }
    
    public function setTmp($tmpId="34445",$param){
        $this->param['TemplateId']=$tmpId;
        $this->param['Content']=implode("||", $param);
        return $this;
    }
    
    public function setSign($signId){
        $this->param['SignId']=$signId;
        return $this;
    }
    
    public function setMobile($mobile){
        $this->param['Mobile']=$mobile;
        return $this;
    }
    
    public function go(){
        $api=with(new \JSocket())->setUrl("http://api.feige.ee/SmsService/Template")->setMethod(\JSocket::methodPost);
        foreach ($this->param as $key=>$value){
            $api->setParam($key,$value);
        }
        return $api->exe()->getRet();
    }
    
    
}
