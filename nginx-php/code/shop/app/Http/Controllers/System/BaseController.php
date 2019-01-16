<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\System;

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class BaseController extends \App\Http\Controllers\BaseController {
    
    public function __construct() {
        parent::__construct();
        $curUser= \SessionHelper::get();
        if($curUser->role!= \App\Models\AdminModel::roleRoot){
            throw new \App\Exceptions\AppException("没有权限");
        }
    }
    
}
