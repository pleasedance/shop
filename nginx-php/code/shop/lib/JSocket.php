<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JSocket
 *
 * @author Administrator
 */
class JSocket {
    const methodGet="GET";              //发起GET请求
    const methodPost="POST";            //发起POST请求
    const methodDelete="DELETE";        //发起DELETE请求
    const methodPut="PUT";          //发起PUT请求
    
    const retFormatJson="JSON";     //返回json格式
    const retFormatXml="XML";       //返回XML格式
    const retFormatText="Text";       //返回XML格式

    private $ch;            //链接对象
    
    private $url;               //请求地址
    private $requestType;       //请求方式
    private $param=[];             //请求参数
    private $timeout=10;           //超时时间
    private $header=[];         //请求头信息
    private $method=JSocket::methodGet;        //请求方式
    private $file;          //文件
    private $ssl;           //证书文件
    
    private $ret;                                   //返回结果
    private $retFormat=JSocket::retFormatJson;      //返回格式
    
    
    public function __construct() {
        $this->ch = curl_init();
    }
    
    public function setRetFormat($retFormat){
        $this->retFormat=$retFormat;
        return $this;
    }

    public function setRequestType($requestType)
    {
        $this->requestType=$requestType;
    }
    
    /**
     * 设置请求地址
     */
    public function setUrl($url){
        $this->url=$url;
        return $this;
    }
    
    /**
     * 设置请求参数
     * @param type $key
     * @param type $value
     * @return \JSocket
     */
    public function setParam($key,$value){
        $this->param[$key]=$value;
        return $this;
    }

    /**
     * 获取请求参数
     * @param type $key
     * @param type $value
     * @return \JSocket
     */
    public function getParam(){
        return $this->param;
    }
    
    /**
     * 设置请求超时时间
     * @param type $timeout
     * @return \JSocket
     */
    public function setTimeout($timeout){
        $this->timeout=$timeout;
        return $this;
    }
    
    /**
     * 设置请求头
     * @param type $header
     * @return \JSocket
     */
    public function setHeader($header){
        $this->header[]=$header;
        return $this;
    }
    
    /**
     * 设置请求方式
     * @param type $method
     * @return \JSocket
     */
    public function setMethod($method){
        $this->method=$method;
        return $this;
    }
    
    /**
     * 设置发送文件
     * @param type $key
     * @param type $value
     * @return \JSocket
     */
    public function setFile($key,$file){
        $this->file[$key]=curl_file_create($file);
        return $this;
    }
    
    /**
     * 设置整数文件
     * @param type $ssl
     * @return \JSocket
     */
    public function ssl($ssl){
        $this->ssl=$ssl;
        return $this;
    }
    
    /**
     * 请求接口
     * @return \JSocket
     */
    public function exe(){
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        if($this->header){
            curl_setopt($this->ch,CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($this->ch,CURLOPT_HEADER,FALSE);
        }
        
        
        switch ($this->method)
        {
            case self::methodPost:
                curl_setopt($this->ch, CURLOPT_POST, TRUE);
                if($this->file){
                    curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->file);
                }
                if($this->param){
                    if ($this->requestType==self::retFormatJson){
                        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->param));
                    }else if ($this->requestType==self::retFormatXml){
                        curl_setopt($this->ch, CURLOPT_POSTFIELDS, \DataBaseHelper::arrayToXml($this->param));
                    }else{
                        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($this->param));
                    }
                }
                break;
                
            case self::methodDelete:
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            case self::methodGet:
                if($this->param){
                    $this->url = $this->url . (strpos($this->url, '?') ? '&' : '?') . http_build_query($this->param);
                }
        }
        if($this->ssl){
            curl_setopt($this->ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($this->ch,CURLOPT_SSLCERT, $this->ssl['cert']);
            curl_setopt($this->ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($this->ch,CURLOPT_SSLKEY, $this->ssl['key']);
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,TRUE);
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
            curl_setopt($this->ch,CURLOPT_HEADER, FALSE);
            if (isset($this->ssl['ca'])){
                curl_setopt($this->ch,CURLOPT_CAINFO, $this->ssl['ca']);
            }
        }else{
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        $starttime=$this->microtimeFloat();
        $this->ret = curl_exec($this->ch);
        $endtime = $this->microtimeFloat();
        $errorNum=curl_errno($this->ch);
        $errorMsg=curl_error($this->ch);
        $runtime = number_format(($endtime-$starttime), 4).'s';
        if($errorNum){
            Log::error($this->url, ["param"=>$this->param,"result"=>$errorNum,"runtime"=>$runtime,"response"=>$this->ret]);
            Log::error("curl请求错误信息：".$errorMsg);
            return NULL;
        }
        $this->http_code = curl_getinfo($this->ch,CURLINFO_HTTP_CODE); 
        curl_close ($this->ch);
        Log::info($this->url, ["param"=>$this->param,"status"=>$this->http_code,"runtime"=>$runtime,"response"=>$this->ret]);
        return $this;
    }
    
    /**
     * 获取结果
     */
    public function getRet(){
        switch ($this->retFormat){
            case JSocket::retFormatJson:
                return json_decode($this->ret,TRUE);
                break;
            case JSocket::retFormatXml:
                return \DataBaseHelper::xmlToArray($this->ret);
                break;
        }
        return $this->ret;
    }
    
    public function getHttpCode(){
        return $this->http_code;
    }
    
    /**
     * 精确时间
     * @return type
     */
    public function microtimeFloat(){
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
