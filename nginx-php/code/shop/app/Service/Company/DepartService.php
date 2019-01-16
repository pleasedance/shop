<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 14:34
 */

namespace App\Service\Company;


class DepartService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\DepartModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\DepartModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->depart_name = $name;
        return $this;
    }

    public function setDescr($descr){
        $this->model->depart_descr = $descr;
        return $this;
    }

    public function setParent($parentId){
        $this->model->parent_id = $parentId;
        return $this;
    }

    public function setCompany(\App\Models\CompanyModel $model){
        $this->model->company_id = $model->company_id;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\DepartModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\DepartModel::statusInactive;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\DepartModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\DepartModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}