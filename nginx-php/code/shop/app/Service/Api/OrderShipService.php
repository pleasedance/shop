<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/7
 * Time: 17:00
 */

namespace App\Service\Api;


class OrderShipService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderShipModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderShipModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderSubSn(\App\Models\OrderSubModel $model){
        $this->model->order_sub_sn = $model->order_sub_sn;
        $this->model->order_sn = $model->order_sn;
        return $this;
    }

    public function setShippingSn($shippingSn){
        $this->model->shipping_sn = $shippingSn;
        return $this;
    }

    public function setShippingCompName($shippingCompName){
        $this->model->shipping_comp_name = $shippingCompName;
        return $this;
    }

    public function setShippingCompCode($shippingCompCode){
        $this->model->shipping_comp_code = $shippingCompCode;
        return $this;
    }

    public function setOrderDetail(\App\Models\OrderDetailModel $model){
        $this->model->order_detail_id = $model->order_detail_id;
        $this->model->product_cnt = $model->product_cnt;
        return $this;
    }

    public function setSendTime(){
        $this->model->send_time = date("Y-m-d H:i:s");
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}