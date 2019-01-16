<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Seller;

/**
 * Description of MainController
 *
 * @author Administrator
 */
class MainController extends BaseController {

    /**
     * @return mixed
     * 登陆页
     */
    public function getIndex(){
        return \View::make("seller/login");
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 登陆接口
     */
    public function postIndex(){
        $loginid = \Jinput::get("loginid");
        if(!$loginid){
            throw new \App\Exceptions\AppException("请先填写账号");
        }
//        $code= \Jinput::get("code");
//        if(!$code){
//            throw new \App\Exceptions\AppException("请填写手机验证码");
//        }
//        $redisCode=\VaildCodeHelper::getLogin($mobile);
//        if(!$redisCode){
//            throw new \App\Exceptions\AppException("验证码已失效请重新发送验证码");
//        }
//        if($redisCode!==$code){
//            throw new \App\Exceptions\AppException("验证码错误");
//        }
        $model=\App\Models\SellerUserModel::where("loginid",$loginid)->first();
        if(!$model || $model->status!= \App\Models\SellerUserModel::statusActive){
            throw new \App\Exceptions\AppException("用户不存在");
        }
        //普通管理员角色被禁用
//        if($model->roleInfo && $model->roleInfo->status!=\App\Models\AdminRoleModel::statusActive){
//            throw new \App\Exceptions\AppException("用户不存在");
//        }
        $password= \Jinput::get("password");
        if(\DataBaseHelper::setPassword($password) != $model->password){
            throw new \App\Exceptions\AppException("用户密码错误");
        }
//        \VaildCodeHelper::delLogin($mobile);
        return \ResponseHelper::success()->withCookie(\CookieHelper::set(\SessionHelper::cookieKey, \SessionHelper::set($model)));
    }

    /**
     * @return mixed
     * 退出登陆
     */
    public function deleteIndex(){
        return \ResponseHelper::success()->withCookie(\CookieHelper::forget(\SessionHelper::cookieKey));
    }

    /**
     * @return mixed
     * 注册页
     */
    public function getRegister(){
        return \View::make("seller/register");
    }

    /**
     * @throws \App\Exceptions\AppException
     * 注册商户
     */
    public function postRegister(){
        $realname = \Jinput::get("realname");
        if(!$realname){
            throw new \App\Exceptions\AppException("请先填写商家名");
        }
        $source = \Jinput::get("source");
        if(!$source){
            throw new \App\Exceptions\AppException("请填写商家来源");
        }
        $province = \Jinput::get("province");
        if(!$province){
            throw new \App\Exceptions\AppException("请填写商家省份");
        }
        $city = \Jinput::get("city");
        if(!$city){
            throw new \App\Exceptions\AppException("请填写商家城市");
        }
        $area = \Jinput::get("area");
        if(!$area){
            throw new \App\Exceptions\AppException("请填写商家区域");
        }
        $mobile = \Jinput::get("mobile");
        if(!$mobile){
            throw new \App\Exceptions\AppException("请填写手机号");
        }

        $sellerModel = \App\Models\SellerModel::where("real_name",$realname)->first();
        if(!$sellerModel){
            //添加商户
            $server = new \App\Service\Seller\MainService();
            $server->setRealname($realname);
            $server->setSource($source);
            $server->setProvince($province);
            $server->setCity($city);
            $server->setArea($area);
            $sellerModel = $server->save();

            //添加商户同时添加该商户超级管理员
            $server = new \App\Service\Seller\SellerUserService();
            $server->setAdmin($sellerModel);
            $server->setRealname("超级管理员");
            $server->setRolename("root");
            $server->setPassword(\DataBaseHelper::setPassword("123456"));
            $server->setLoginId($mobile);
            $server->setPhone($mobile);
            $server->setSource("app");
            $server->setSex(\App\Models\SellerUserModel::sexSecrecy);
            $sellerUserModel = $server->save();
        }
        return \ResponseHelper::success(["id"=>$sellerModel->seller_id]);
    }
}
