<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14
 * Time: 16:39
 */

namespace App\Service\Company;


class CartService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CartModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CartModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setSeller(\App\Models\SellerModel $model){
        $this->model->seller_id = $model->seller_id;
        return $this;
    }

    public function setSkuUniqueCode(\App\Models\SkuPropertiesModel $model){
        $this->model->sku_unique_code = $model->sku_unique_code;
        $this->model->sku_code = $model->sku_code;
        return $this;
    }

    public function setSkuCode($skuCode){
        $this->model->sku_code = $skuCode;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function setProduct(\App\Models\ProductModel $model){
        $this->model->product_number = $model->product_number;
        $this->model->product_id = $model->product_id;
        return $this;
    }

    public function setAmount($amount){
        $this->model->product_amount = $amount;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\CartModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\CartModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}