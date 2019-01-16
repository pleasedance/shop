<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14
 * Time: 16:51
 */

namespace App\Service\Api;


class OrderRechargeService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderRechargeModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderRechargeModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderRechargeSn($orderRechargeSn){
        $this->model->order_recharge_sn = $orderRechargeSn;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function setCompany(\App\Models\CompanyModel $model){
        $this->model->company_id = $model->company_id;
        return $this;
    }

    public function setMoney($money){
        $this->model->money = $money;
        return $this;
    }

    public function setPayTime(){
        $this->model->pay_time = date("Y-m-d H:i:s");
        return $this;
    }

    public function setPayPrice($payPrice){
        $this->model->pay_price = $payPrice;
        return $this;
    }

    public function setPaySn($paySn){
        $this->model->pay_sn = $paySn;
        return $this;
    }

    public function setWxMethod(){
        $this->model->payment_method = \App\Models\OrderRechargeModel::wxMethod;
        return $this;
    }

    public function setSuccess(){
        $this->model->pay_status = \App\Models\OrderRechargeModel::success;
        return $this;
    }

    public function setFail(){
        $this->model->pay_status = \App\Models\OrderRechargeModel::fail;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}