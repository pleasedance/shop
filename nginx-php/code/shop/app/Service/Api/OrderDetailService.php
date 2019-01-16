<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/21
 * Time: 15:00
 */

namespace App\Service\Api;


class OrderDetailService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderDetailModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderDetailModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderSubSn($orderSubSn){
        $this->model->order_sub_sn = $orderSubSn;
        return $this;
    }

    public function setOrderSn($orderSn){
        $this->model->order_sn = $orderSn;
        return $this;
    }

    public function setProduct(\App\Models\ProductModel $model){
        $this->model->product_number = $model->product_number;
        $this->model->product_art_no = $model->product_art_no;
        $this->model->product_name = $model->product_art_no;
        return $this;
    }

    public function setCnt($cnt){
        //购买数量
        $this->model->product_cnt = $cnt;
        return $this;
    }

    public function setMoney($money){
        //商品单价
        $this->model->product_money = $money;
        return $this;
    }

    public function setDiscountMoney($discountMoney){
        $this->model->discount_money = $discountMoney;
        return $this;
    }

    public function setShippingMoney($shippingMoney){
        $this->model->shipping_money = $shippingMoney;
        return $this;
    }

    public function setDetailGrowth($detailGrowth){
        //订单可获得成长值
        $this->model->order_detail_growth = $detailGrowth;
        return $this;
    }

    public function setDetailLeGlod($detailLeGlod){
        //订单可获得乐币
        $this->model->order_detail_le_glod = $detailLeGlod;
        return $this;
    }

    public function setSkuUniqueCode(\App\Models\SkuPropertiesModel $model){
        $this->model->sku_unique_code = $model->sku_unique_code;
        $this->model->sku_code = $model->sku_code;
        return $this;
    }

    public function setProductSku(\App\Models\SkuModel $model){
        $this->model->product_sku_attr = $model->property;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }

}