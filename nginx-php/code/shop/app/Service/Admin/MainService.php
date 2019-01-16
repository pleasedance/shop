<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Admin;

/**
 * 超级管理员 操作服务
 * @author Administrator
 */
class MainService {
    private $model;
    private $create=FALSE;
    
    public function __construct(\App\Models\AdminModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\AdminModel();
            $model->role= \App\Models\AdminModel::roleRoot;
            $model->status= \App\Models\AdminModel::statusActive;
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }
    
    /**
     * 设置手机号
     * @param type $mobile
     * @return $this
     */
    public function setMobile($mobile){
        if($this->create){
            $exsitModel= \App\Models\AdminModel::where("mobile",$mobile)->first();
            if($exsitModel){
                throw new \App\Exceptions\AppException("手机号已存在");
            }
        }else{
            $exsitModel= \App\Models\AdminModel::where("mobile",$mobile)->where("id","!=",$this->model->id)->first();
            if($exsitModel){
                throw new \App\Exceptions\AppException("手机号已存在");
            }
        }
        $this->model->mobile=$mobile;
        return $this;
    }
    
    /**
     * 设置用户名
     * @param type $name
     * @return $this
     */
    public function setName($name){
        $this->model->name=$name;
        return $this;
    }
    
    /**
     * 角色权限
     * @param \App\Models\AdminRoleModel $adminRoleModel
     * @return $this
     */
    public function setRole(\App\Models\AdminRoleModel $adminRoleModel){
        $this->model->role=$adminRoleModel->code;
        return $this;
    }
    
    /**
     * 保存
     * @return type
     * @throws \App\Exceptions\AppException
     */
    public function save(){
        $this->model->save();
        \App\Data\AdminData::flash($this->model->id);
        return $this->model;
    }
    
    /**
     * 激活
     * @return type
     */
    public function active(){
        $this->model->status=\App\Models\AdminModel::statusActive;
        $this->model->save();
        \App\Data\AdminData::flash($this->model->id);
        return $this->model;
    }
    
    /**
     * 禁用
     * @return type
     */
    public function inactive(){
        $this->model->status=\App\Models\AdminModel::statusInactive;
        $this->model->save();
        \App\Data\AdminData::flash($this->model->id);
        \SessionHelper::eliminate($this->model);        //把管理员踢下线
        return $this->model;
    }
    
    /**
     * 修改密码
     * @param type $pwd
     * @return \App\Models\AdminPwdModel
     */
    public function pwd($pwd){
        $adminPwdModel=\App\Models\AdminPwdModel::find($this->model->id);
        if(!$adminPwdModel){
            $adminPwdModel=new \App\Models\AdminPwdModel();
            $adminPwdModel->admin_id=$this->model->id;
        }
        $adminPwdModel->pwd_salt= str_random();
        $adminPwdModel->pwd_hash= \DataBaseHelper::setPassword($pwd, $adminPwdModel->pwd_salt);
        $adminPwdModel->save();
        \SessionHelper::eliminate($this->model);    //把管理员踢下线
        return $adminPwdModel;
    }
    
}
