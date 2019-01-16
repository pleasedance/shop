<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 18:46
 */

namespace App\Service\Company;


class CompanyUserService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CompanyUserModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CompanyUserModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setUserName($userName){
        $this->model->username = $userName;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\CompanyUserModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\CompanyUserModel::statusInactive;
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

    public function setEmail($email){
        $this->model->email = $email;
        return $this;
    }

    public function setCompanyId(\App\Models\CompanyModel $model){
        $this->model->company_id = $model->company_id;
        return $this;
    }

    public function setRole(\App\Models\CompanyRoleModel $model){
        $this->model->role_id = $model->role_id;
        $this->model->role_name = $model->role_name;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}