<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:49
 */

namespace App\Http\Controllers\System\Admin;


class BaseController extends \App\Http\Controllers\Controller
{
    protected $curUser;
    public function __construct() {
        $this->curUser= \SystemSessionHelper::get();
        if(!$this->curUser){
            throw new \App\Exceptions\SessionException("请先登陆");
        }
//        if(!\PermissionHelper::can($this->curUser, \PermissionHelper::seller)){
//            throw new \App\Exceptions\AppException("没有权限");
//        }
    }
}