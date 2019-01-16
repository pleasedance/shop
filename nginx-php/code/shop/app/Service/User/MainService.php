<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\User;

/**
 * Description of MainService
 *
 * @author Administrator
 */
class MainService {
    
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\UserModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\UserModel();
            $model->from= \App\Models\UserModel::fromExcel;
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }
    
    public function setMobile($mobile){
        if($this->create){
            $exsit=\App\Models\UserModel::where("mobile",$mobile)->first();
        }else{
            $exsit=\App\Models\UserModel::where("mobile",$mobile)->where("id","!=", $this->model->id)->first();
        }
        if($exsit){
            throw new \App\Exceptions\AppException("手机号码已存在");
        }
        $this->model->mobile=$mobile;
        return $this;
    }
    
    public function setRealname($realname){
        $this->model->realname=$realname;
        return $this;
    }
    
    public function setAdmin(\App\Models\AdminModel $adminModel){
        $this->model->admin_id=$adminModel->id;
        return $this;
    }
    
    public function setIdCard($idCard){
        if($idCard){
            if(!\ValidateHelper::isIdCard($idCard)){
                throw new \App\Exceptions\AppException("身份证号".$idCard."错误");
            }
        }
        $this->model->id_card=$idCard;
        return $this;
    }
    
    public function setBrank($brank){
        $this->model->brank=$brank;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        return $this->model;
    }
    
}
