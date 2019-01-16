<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class BaseController extends \App\Http\Controllers\Controller {
    protected $curUser;
    public function __construct() {
        $this->curUser = \BuyerSessionHelper::get();
        if(!$this->curUser){
            return \ResponseHelper::error("请先登陆",NULL,10001,200);
        }
//        if(!\PermissionHelper::can($this->curUser, \PermissionHelper::seller)){
//            throw new \App\Exceptions\AppException("没有权限");
//        }
    }
}
