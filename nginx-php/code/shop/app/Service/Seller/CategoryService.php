<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/8
 * Time: 16:43
 */

namespace App\Service\Seller;


class CategoryService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CategoryModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CategoryModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setParentId($parentId){
        $this->model->parent_id=$parentId;
        return $this;
    }

    public function setBrand(\App\Models\BrandModel $model){
        $this->model->brand_id=$model->brand_id;
        return $this;
    }

    public function setName($categoryName){
        $this->model->name=$categoryName;
        return $this;
    }

    public function setDescr($descr){
        $this->model->descr=$descr;
        return $this;
    }

    public function setPictureUrl($pictureUrl){
        $this->model->picture_url=$pictureUrl;
        return $this;
    }

    public function setLevel($level){
        $this->model->level=$level;
        return $this;
    }

    public function setSort($sort){
        $this->model->sort=$sort;
        return $this;
    }

    public function setUnit($unit){
        $this->model->unit=$unit;
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

    public function save(){
        $this->model->save();
        return $this->model;
    }
}