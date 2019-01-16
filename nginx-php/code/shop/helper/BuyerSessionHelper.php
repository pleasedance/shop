<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14
 * Time: 13:29
 */

class BuyerSessionHelper
{
    //小程序不支持cookie
    const Key="BuyerFlowToken";

    public static function set(App\Models\BuyerModel $model){
        self::eliminate($model);
        $key="buyerflow_a_".$model->buyer_id."_".str_random(32);
        RedisSessionHelper::save($key, $model->buyer_id,3600*24);
        self::$get=$model;
        return $key;
    }

    private static $get;
    public static function get(){
        if(self::$get){
            return self::$get;
        }
        //获取token
        $request = \Request::all();
        $token = $request[self::Key];
        $id = RedisSessionHelper::fetch($token);
        if(!$id){
            return NULL;
        }
        self::$get = \App\Data\BuyerData::info($id);
        self::keep();
        return self::$get;
    }

    public static function forget(){
        //获取token
        $request = \Request::all();
        $token = $request[self::Key];
        RedisSessionHelper::delete($token);
    }


    public static function keep($data=NULL){
        //获取token
        $request = \Request::all();
        $token = $request[self::Key];
        if(!$data){
            $data=RedisSessionHelper::fetch($token);
        }
        if($data){
            if($token){
                RedisSessionHelper::save($token, $data,3600*24);
            }
        }
    }

    /**
     * 将某个用户踢下线
     * @param type $model
     */
    public static function eliminate(App\Models\BuyerModel $model){
        $key="buyerflow_a_".$model->buyer_id."_*";
        $list=RedisSessionHelper::keys($key);
        if($list){
            foreach ($list as $value){
                RedisSessionHelper::delete($value);
            }
        }
    }

    /**
     * @param \App\Models\BuyerModel $model
     * 刷新数据
     */
    public static function flush(){
        $request = \Request::all();
        $token = $request[self::Key];
        $id = RedisSessionHelper::fetch($token);
        if(!$id){
            return NULL;
        }
        \App\Data\BuyerData::flash($id);
    }
}