<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 13:15
 */

namespace App\Service\Seller;


class SkuPropertiesService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SkuPropertiesModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\SkuPropertiesModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setPrice($price){
        $this->model->pd_price = $price;
        return $this;
    }

    public function setMemberPrice($memberPrice){
        $this->model->member_price = $memberPrice;
        return $this;
    }

    public function setStocks($stocks){
        $this->model->pd_stocks = $stocks;
        return $this;
    }

    public function setFrozenStocks($frozenStocks){
        $this->model->pd_frozen_stocks = $frozenStocks;
        return $this;
    }

    public function setAlarmStocks($alarmStocks){
        $this->model->pd_alarm_stocks = $alarmStocks;
        return $this;
    }

    public function setSkuUniqueCode($skuUniqueCode){
        $this->model->sku_unique_code = $skuUniqueCode;
        return $this;
    }

    public function setSkuPictureUrl($skuPictureUrl){
        $this->model->sku_picture_url = $skuPictureUrl;
        return $this;
    }

    public function setSkuCode($skuCode){
        $this->model->sku_code = $skuCode;
        return $this;
    }

    public function setProductNumber($productNumber){
        $this->model->product_number = $productNumber;
        return $this;
    }

    public function setVersion($version){
        $this->model->version = $version;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}