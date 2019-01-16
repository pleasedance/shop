<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 18:42
 */

namespace App\Service\Company;


class CompanyService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CompanyModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CompanyModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->name = $name;
        return $this;
    }

    public function setMoney($money){
        $this->model->money += $money;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\CompanyModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\CompanyModel::statusInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}