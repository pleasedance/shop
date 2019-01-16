<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 13:54
 */

namespace App\Service\Company;


class CompanyRoleService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CompanyRoleModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CompanyRoleModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->role_name=$name;
        return $this;
    }

    public function setDescr($descr){
        $this->model->role_descr=$descr;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\CompanyRoleModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\CompanyRoleModel::statusInactive;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\CompanyRoleModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\CompanyRoleModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}