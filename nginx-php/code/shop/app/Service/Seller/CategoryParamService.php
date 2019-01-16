<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/9
 * Time: 15:15
 */

namespace App\Service\Seller;


class CategoryParamService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CategoryParamModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CategoryParamModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setParamNumber($paramNumber){
        $this->model->param_number=$paramNumber;
        return $this;
    }

    public function setParamName($paramName){
        $this->model->param_name=$paramName;
        return $this;
    }

    public function setSort($sort){
        $this->model->sort=$sort;
        return $this;
    }

    public function setSearchActive(){
        $this->model->is_search=\App\Models\CategoryParamModel::searchActive;
        return $this;
    }

    public function setSearchInactive(){
        $this->model->is_search=\App\Models\CategoryParamModel::searchInactive;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\CategoryModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\CategoryModel::statusInactive;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\CategoryModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\CategoryModel::delInactive;
        return $this;
    }

    public function setShowNavigation(){
        $this->model->navigation_status=\App\Models\CategoryModel::showNavigation;
        return $this;
    }

    public function setNoshowNavigation(){
        $this->model->navigation_status=\App\Models\CategoryModel::noshowNavigation;
        return $this;
    }

    public function setCategory(\App\Models\CategoryModel $model){
        $this->model->category_id=$model->category_id;
        $this->model->category_name=$model->name;
        $this->model->unit=$model->unit;
        if ($model->navigation_status){
            $this->setShowNavigation();
        }else{
            $this->setNoshowNavigation();
        }
        return $this;
    }

    public function setProduct(\App\Models\ProductModel $model){
        $this->model->product_number=$model->product_number;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        return $this->model;
    }
}