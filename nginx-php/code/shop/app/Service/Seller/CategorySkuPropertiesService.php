<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 13:37
 */

namespace App\Service\Seller;


class CategorySkuPropertiesService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CategorySkuPropertiesModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CategorySkuPropertiesModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setCategory($model){
        $this->model->sku_number=$model->sku_number;
        $this->model->category_id=$model->category->category_id;
        $this->model->propertie_name=$model->propertie_name;
        return $this;
    }

    public function setSkuPropertieValue($skuPropertieValue){
        $this->model->sku_propertie_value=$skuPropertieValue;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}