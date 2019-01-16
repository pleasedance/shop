<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 11:02
 */

namespace App\Http\Controllers\Company\CompanyAdmin;


class BaseController extends \App\Http\Controllers\Controller
{
    protected $curUser;
    public function __construct() {
        $this->curUser= \CompanySessionHelper::get();
        if(!$this->curUser){
            throw new \App\Exceptions\SessionException("请先登陆");
        }
//        if(!\PermissionHelper::can($this->curUser, \PermissionHelper::seller)){
//            throw new \App\Exceptions\AppException("没有权限");
//        }
    }
}