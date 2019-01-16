<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/4
 * Time: 19:23
 */

namespace App\Service\Api;


class OrderReturnsService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderReturnsModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderReturnsModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setSn($sn){
        $this->model->order_return_sn = $sn;
        return $this;
    }

    public function setOrder(\App\Models\OrderModel $model){
        $this->model->order_sn = $model->order_sn;
        return $this;
    }

    public function setOrderDetail(\App\Models\OrderDetailModel $model){
        $this->model->product_number = $model->product_number;
        return $this;
    }

    public function setSubOrder(\App\Models\OrderSubModel $model){
        $this->model->order_sub_sn = $model->order_sub_sn;
        $this->model->seller_id = $model->seller_id;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
    }

    public function setRefunding(){
        $this->model->refund_status = \App\Models\OrderReturnsModel::refunding;
    }

    public function setRefunded(){
        $this->model->refund_status = \App\Models\OrderReturnsModel::refunded;
    }

    public function setReturnGoodsing(){
        $this->model->return_goods_status = \App\Models\OrderReturnsModel::returnGoodsing;
    }

    public function setReturnGoodsed(){
        $this->model->return_goods_status = \App\Models\OrderReturnsModel::returnGoodsed;
    }

    public function setRefuseDeal(){
        $this->model->return_goods_status = \App\Models\OrderReturnsModel::refuseDeal;
    }

    public function setApplyDeal(){
        $this->model->return_goods_status = \App\Models\OrderReturnsModel::applyDeal;
    }

    public function setSellerAddress(\App\Models\SellerAddressModel $model){
        $this->model->seller_address_id = $model->id;
    }

    public function setFreightMoney($freightMoney){
        $this->model->freight_money = $freightMoney;
    }

    public function setShippingSn($shippingSn){
        $this->model->shipping_sn = $shippingSn;
    }

    public function setShippingCompName($shippingCompName){
        $this->model->shipping_comp_name = $shippingCompName;
    }

    public function setRefuseReason($refuseReason){
        $this->model->refuse_reason = $refuseReason;
    }

    public function setApplyReturnGoods(){
        $this->model->return_goods_status = \App\Models\OrderSubModel::statusApplyReturnGoods;
    }

    public function setDelTime(){
        $this->model->del_time = date("Y-m-d H:i:s");
    }

    public function setReturnGoodsTime(){
        $this->model->return_goods_time = date("Y-m-d H:i:s");
    }

    public function setRefundTime(){
        $this->model->refund_time = date("Y-m-d H:i:s");
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}