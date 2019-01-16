<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 11:21
 */

namespace App\Service\Seller;


class SkuService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SkuModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\SkuModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setProductNumber($productNumber){
        $this->model->product_number = $productNumber;
        return $this;
    }

    public function setProperty($property){
        $this->model->property = $property;
        return $this;
    }

    public function setSkuItem($skuItem){
        $this->model->sku_item = $skuItem;
        return $this;
    }

    public function setSkuValue($skuValue){
        $this->model->sku_value = $skuValue;
        return $this;
    }

    public function setSkuSort($skuSort){
        $this->model->sku_sort = $skuSort;
        return $this;
    }

    public function setSkuUniqueCode($skuUniqueCode){
        $this->model->sku_unique_code = $skuUniqueCode;
        return $this;
    }

    public function setSkuCode($skuCode){
        $this->model->sku_code = $skuCode;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status = \App\Models\SkuModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status = \App\Models\SkuModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}