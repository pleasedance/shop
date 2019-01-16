<?php

namespace App\Http\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class BaseController extends Controller {
    
    public function __construct() {
        $userModel= \SessionHelper::get();
        if(!$userModel){
            throw new \App\Exceptions\SessionException("请先登陆");
        }
    }
    
    
    
}
