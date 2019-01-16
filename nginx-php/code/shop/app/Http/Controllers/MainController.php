<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of MainController
 *
 * @author Administrator
 */
class MainController extends BaseController {
    
    
    public function getIndex(){
        $companyNum= \App\Models\CompanyModel::count();
        $userNum= \App\Models\UserModel::count();
        return \View::make("main/index",["companyNum"=>$companyNum,"userNum"=>$userNum]);
    }
    
    public function getProfile(){
        $curUser= \SessionHelper::get();
        return \View::make("main/profile",["curUser"=>$curUser]);
    }
    
    public function postProfile(){
        $mobile= \Jinput::get("mobile");
        $name= \Jinput::get("name");
        $pwd= \Jinput::get("password");
        $repwd= \Jinput::get("repassword");
        if(!empty($pwd)){
            if(empty($repwd)){
                throw new \App\Exceptions\AppException("请填写重复密码");
            }
            if($pwd!=$repwd){
                throw new \App\Exceptions\AppException("重复密码错误");
            }
        }
        if(empty($mobile)){
            throw new \App\Exceptions\AppException("请填写手机号码");
        }
        if(!\ValidateHelper::isMobile($mobile)){
            throw new \App\Exceptions\AppException("手机号码格式错误");
        }
        if(empty($name)){
            throw new \App\Exceptions\AppException("请填写用户名");
        }
        $curUser= \SessionHelper::get();
        $server=new \App\Service\Admin\MainService($curUser);
        $server->setName($name);
        $server->setMobile($mobile);
        $server->save();
        if(!empty($pwd)){
            $server->pwd($pwd);
        }
        return \ResponseHelper::success();
    }
    
    
}
