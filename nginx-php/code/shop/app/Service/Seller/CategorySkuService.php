<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 10:31
 */

namespace App\Service\Seller;


class CategorySkuService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CategorySkuModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CategorySkuModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setCategory(\App\Models\CategoryModel $model){
        $this->model->category_id=$model->category_id;
        $this->model->category_name=$model->name;
        return $this;
    }

    public function setSkuNumber($skuNumber){
        $this->model->sku_number=$skuNumber;
        return $this;
    }

    public function setPropertieName($propertieName){
        $this->model->propertie_name=$propertieName;
        return $this;
    }

    public function setSort($sort){
        $this->model->sort=$sort;
        return $this;
    }

    public function setMultChooseActive(){
        $this->model->is_mult_choose=\App\Models\CategorySkuModel::multChooseActive;
        return $this;
    }

    public function setMultChooseInactive(){
        $this->model->is_mult_choose=\App\Models\CategorySkuModel::multChooseInactive;
        return $this;
    }

    public function setSearchActive(){
        $this->model->is_search=\App\Models\CategorySkuModel::searchActive;
        return $this;
    }

    public function setSearchInactive(){
        $this->model->is_search=\App\Models\CategorySkuModel::searchInactive;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\CategorySkuModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\CategorySkuModel::statusInactive;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\CategorySkuModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\CategorySkuModel::delInactive;
        return $this;
    }


    public function save(){
        $this->model->save();
        return $this->model;
    }
}