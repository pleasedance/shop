<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9
 * Time: 11:31
 */

namespace App\Service\Api;


class OrderReturnsDetailService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderReturnsDetailModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderReturnsDetailModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderReturn(\App\Models\OrderReturnsModel $model){
        $this->model->order_return_sn = $model->order_return_sn;
        $this->model->order_sub_sn = $model->order_sub_sn;
        $this->model->order_sn = $model->order_sn;
        return $this;
    }

    public function setOrderSub(\App\Models\OrderSubModel $model){
        $this->model->payment_money = $model->payment_money;
        return $this;
    }

    public function setOrder(\App\Models\OrderModel $model){
        $this->model->order_sn = $model->order_sn;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function setOrderDetail(\App\Models\OrderDetailModel $model){
        $this->model->product_number = $model->product_number;
        $this->model->product_name = $model->product_name;
        $this->model->product_cnt = $model->product_cnt;
        $this->model->product_money = $model->product_money;
        $this->model->product_cnt = $model->product_cnt;
        $this->model->sku_unique_code = $model->sku_unique_code;
        $this->model->sku_code = $model->sku_code;
        $this->model->product_sku_attr = $model->product_sku_attr;
        return $this;
    }

    public function setReturnGoodsReason($returnGoodsReason){
        $this->model->return_goods_reason = $returnGoodsReason;
        return $this;
    }

    public function setReturnGoodsDesr($returnGoodsDesr){
        $this->model->return_goods_desr = $returnGoodsDesr;
        return $this;
    }

    public function setReturnGoodsImg($returnGoodsImg){
        $this->model->return_goods_img = $returnGoodsImg;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}