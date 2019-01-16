<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 15:42
 */

namespace App\Service\Company;


class MoneyLogService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\MoneyLogModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\MoneyLogModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setRecharge(){
        $this->model->status = \App\Models\MoneyLogModel::statusRecharge;
        return $this;
    }

    public function setConsume(){
        $this->model->status = \App\Models\MoneyLogModel::statusConsume;
        return $this;
    }

    public function setCompanyRecharge(){
        $this->model->type = \App\Models\MoneyLogModel::companyRecharge;
        return $this;
    }

    public function setUserRecharge(){
        $this->model->type = \App\Models\MoneyLogModel::userRecharge;
        return $this;
    }

    public function setCpToCpRecharge(){
        $this->model->type = \App\Models\MoneyLogModel::cpTocpRecharge;
        return $this;
    }

    public function setOrder($orderSn){
        $this->model->order_sn = $orderSn;
        return $this;
    }

    public function setSubOrder($orderSubSn){
        $this->model->order_sub_sn = $orderSubSn;
        return $this;
    }

    public function setPaySn($paySn){
        $this->model->pay_sn = $paySn;
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

    public function setIp($ip){
        $this->model->ip = $ip;
        return $this;
    }

    public function setWxMoney($money){
        $this->model->wx_money = $money;
        return $this;
    }

    public function setUserMoney($money){
        $this->model->user_money = $money;
        return $this;
    }

    public function setRemark($remark){
        $this->model->remark = $remark;
        return $this;
    }

    public function setOrderType(){
        $this->model->order_type = \App\Models\MoneyLogModel::order;
        return $this;
    }

    public function setOrderSubType(){
        $this->model->order_type = \App\Models\MoneyLogModel::orderSub;
        return $this;
    }

    public function setOrderRecharge(){
        $this->model->order_type = \App\Models\MoneyLogModel::orderRecharge;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}