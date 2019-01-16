<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oss
 *
 * @author Administrator
 */
//class OssClient extends OSS\OssClient {
//    private $bucket;
//    public function __construct($bucket) {
//        $this->bucket=$bucket;
//        parent::__construct(Config::get("oss.accessKeyId"), Config::get("oss.accessKeySecret"),Config::get("oss.domain"));
//    }
//    
//    public function upload($object, $file, $options = NULL) {
//        parent::uploadFile(Config::get("oss.".$this->bucket.".bucket"), $object, $file, $options);
//    }
//}



class OssClient{
    private static $token;
    public static function getToken(){
        if(!self::$token){
            $auth = new \Qiniu\Auth(\Config::get("qiniu.accessKey"), \Config::get("qiniu.secretKey"));
            self::$token = $auth->uploadToken(\Config::get("qiniu.bucket"));
        }
        return self::$token;
    }
    
    public function upload($object, $file) {
        $api=new \Qiniu\Storage\UploadManager();
        $api->putFile(OssClient::getToken(), $object, $file);
    }
}