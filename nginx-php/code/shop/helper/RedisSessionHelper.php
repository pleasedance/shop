<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionRedis
 *
 * @author Administrator
 */
class RedisSessionHelper extends RedisBaseHelper{
    
    public static function getRedis(){
        return \Illuminate\Support\Facades\Redis::connection("session");
    }
    
    /**
     * 保存数据到redis
     * @param type $key
     * @param type $value
     * @param type $time
     * @return type
     */
    public static function save($key,$value,$time=3600){
        $redis=self::getRedis();
        return $redis->setex($key,$time,parent::valueEn($value));
    }
    
    /**
     * 获取缓存数据
     * @param type $key
     * @return type
     */
    public static function fetch($key){
        $redis=self::getRedis();
        $value=$redis->get($key);
        return parent::valueDe($value);
    }
    
    public static function ttl($key){
        $redis=self::getRedis();
        return $redis->ttl($key);
    }
    
    
    /**
     * 上次缓存数据
     * @param type $key
     * @return type
     */
    public static function delete($key){
        $redis=self::getRedis();
        if($redis->ttl($key)>0){
            return $redis->del(array($key));
        }
    }
    
    public static function keys($key){
        $redis=self::getRedis();
        return $redis->keys($key);
    }
    
     /**
     * 哈希get
     * @param $key
     * @param $field
     * @return type
     */
    public static function hGet($key, $field) {
        $redis=self::getRedis();
        return parent::valueDe($redis->hGet($key, $field));
    }

    /**
     * 哈希set
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hSet($key, $field, $value) {
        $redis=self::getRedis();
        return $redis->hSet($key, $field, parent::valueEn($value));
    }

    /**
     * 哈希删除
     * @param $key
     * @param $field
     * @return mixed
     */
    public static function hDel($key, $field) {
        $redis=self::getRedis();
        return $redis->hDel($key, $field);
    }
}
