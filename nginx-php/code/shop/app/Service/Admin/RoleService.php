<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Admin;

/**
 * Description of RoleService
 *
 * @author Administrator
 */
class RoleService {
    private $model;
    
    public function __construct(\App\Models\AdminRoleModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\AdminRoleModel();
            $model->code= str_random(6);
            $model->status= \App\Models\AdminRoleModel::statusActive;
        }
        $this->model=$model;
        return $this;
    }
    
    /**
     * 设置角色名
     * @param type $name
     * @return $this
     */
    public function setName($name){
        $this->model->name=$name;
        return $this;
    }
    
    /**
     * 设置权限编号
     * @param type $permission
     */
    public function setPermission($permission){
        $this->model->permission=$permission;
        return $this;
    }
    
    /**
     * 保存
     * @return type
     */
    public function save(){
        $this->model->save();
        return $this->model;
    }
    
    /**
     * 激活角色
     * @return type
     */
    public function active(){
        $this->model->status= \App\Models\AdminRoleModel::statusActive;
        $this->model->save();
        return $this->model;
    }
    
    /**
     * 禁用角色
     * @return type
     */
    public function inactive(){
        $this->model->status= \App\Models\AdminRoleModel::statusInactive;
        $this->model->save();
        //该角色下所有管理员踢下线
        $list=\App\Models\AdminModel::where("role", $this->model->code)->get();
        if($list->toArray()){
            foreach ($list as $adminModel){
                \SessionHelper::eliminate($adminModel);
            }
        }
        return $this->model;
    }
}
