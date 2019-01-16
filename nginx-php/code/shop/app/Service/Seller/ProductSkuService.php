<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 17:48
 */

namespace App\Service\Seller;


class ProductSkuService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\ProductSkuModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\ProductSkuModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->name = $name;
        return $this;
    }

    public function setValue($value){
        $this->model->value = $value;
        return $this;
    }

    public function setProductNumber($productNumber){
        $this->model->product_number = $productNumber;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\ProductSkuModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\ProductSkuModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}