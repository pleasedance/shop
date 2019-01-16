<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CompanySdk;

/**
 * Description of Phone
 *
 * @author 唐锦龙
 */

 
class AdminManger extends CompanySdkBase {
    
    protected $route="admin";
    protected $method=\JSocket::methodPost;
    protected $param=[];
    
}
