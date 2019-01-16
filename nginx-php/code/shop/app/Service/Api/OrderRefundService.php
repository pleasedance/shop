<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 12:58
 */

namespace App\Service\Api;


class OrderRefundService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderRefundModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderRefundModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderRefundSn($orderRefundSn){
        $this->model->order_refund_sn = $orderRefundSn;
        return $this;
    }

    public function setOrder(\App\Models\OrderModel $model){
        $this->model->order_sn = $model->order_sn;
        $this->model->pay_sn = $model->pay_sn;
        return $this;
    }

    public function setSubOrder(\App\Models\OrderSubModel $model){
        $this->model->order_sub_sn = $model->order_sub_sn;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function setRefunding(){
        $this->model->refund_status = \App\Models\OrderRefundModel::refunding;
        return $this;
    }

    public function setRefunded(){
        $this->model->refund_status = \App\Models\OrderRefundModel::refunded;
        return $this;
    }

    public function setRefundMoney($money){
        $this->model->refund_money = $money;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}