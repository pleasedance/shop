<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18
 * Time: 13:47
 */

namespace App\Service\System;


class SystemUserService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SystemUserModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\SystemUserModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\SystemUserModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\SystemUserModel::statusInactive;
        return $this;
    }

    public function setPassword($password){
        $this->model->password = \DataBaseHelper::setPassword($password);
        return $this;
    }

    public function setLoginId($loginId){
        $this->model->loginid = $loginId;
        return $this;
    }

    public function setRole(\App\Models\SellerRoleModel $model){
        $this->model->role_id = $model->role_id;
        $this->model->role_name = $model->role_name;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}