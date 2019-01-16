<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:27
 */

namespace App\Http\Controllers\System;


class MainController extends \App\Http\Controllers\Controller
{
    /**
     * @return mixed
     * 登陆页
     */
    public function getIndex()
    {
        return \View::make("system/login");
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 登陆
     */
    public function postIndex()
    {
        $request = \Request::all();
        $loginid = $request["loginid"];
        if(!$loginid){
            throw new \App\Exceptions\AppException("请先填写账号");
        }
        $model = \App\Models\SystemUserModel::where("loginid",$loginid)->first();
        if(!$model || $model->status!= \App\Models\SystemUserModel::statusActive){
            throw new \App\Exceptions\AppException("用户不存在");
        }
        $password = $request["password"];
        if(\DataBaseHelper::setPassword($password) != $model->password){
            throw new \App\Exceptions\AppException("用户密码错误");
        }
        return \ResponseHelper::success()->withCookie(\CookieHelper::set(\SystemSessionHelper::cookieKey, \SystemSessionHelper::set($model)));
    }

    /**
     * @return mixed
     * 退出登陆
     */
    public function deleteIndex()
    {
        return \ResponseHelper::success()->withCookie(\CookieHelper::forget(\SystemSessionHelper::cookieKey));
    }
}