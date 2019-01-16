<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedisBaseHelper
 *
 * @author Administrator
 */
class RedisBaseHelper {
    
    /**
     * 对需要保存的数据加密
     * @param type $value
     * @return type
     */
    protected static function valueEn($value){
        return serialize($value);
    }
    
    /**
     * 对从缓存获取的数据解密
     * @param type $value
     * @return type
     */
    protected static function valueDe($value){
        return unserialize($value);
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
        return $redis->setex($key,$time,self::valueEn($value));
    }
    
    /**
     * 获取缓存数据
     * @param type $key
     * @return type
     */
    public static function fetch($key){
        $redis=self::getRedis();
        $value=$redis->get($key);
        return self::valueDe($value);
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

    /**
     * 推入队列
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function push($key, $value) {
        $redis=self::getRedis();
        return $redis->rPush($key, self::valueEn($value));
    }

    /**
     * 从队列中取出
     * @param $key
     * @return mixed
     */
    public static function pop($key) {
        $redis=self::getRedis();
        $value = $redis->lPop($key);

        $result = [];
        if(count($value) > 0) {
            foreach ($value as $v) {
                $result[] = parent::valueDe($v);
            }
        }
        return $result;
    }
    
}
