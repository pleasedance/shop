<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/28
 * Time: 17:13
 */

namespace App\Service\Seller;


class OrderSubService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderSubModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderSubModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderSubSn($orderSubSn){
        $this->model->order_sub_sn = $orderSubSn;
        return $this;
    }

    public function setSeller(\App\Models\SellerModel $model){
        $this->model->seller_id = $model->seller_id;
        return $this;
    }

    public function setOrderSn($orderSn){
        $this->model->order_sn = $orderSn;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        $this->model->buyer_phone = $model->phone;
        return $this;
    }

    public function setNeedPayMoney($needPayMoney){
        $this->model->need_pay_money = $needPayMoney;
        return $this;
    }

    public function setProductMoney($productMoney){
        $this->model->product_money = $productMoney;
        return $this;
    }

    public function setPaymentMoney($paymentMoney){
        $this->model->payment_money = $paymentMoney;
        return $this;
    }

    public function setDiscountMoney($discountMoney){
        $this->model->discount_money = $discountMoney;
        return $this;
    }

    public function setActivityMoney($activityMoney){
        $this->model->activity_money = $activityMoney;
        return $this;
    }

    public function setShippingMoney($shippingMoney){
        $this->model->shipping_money = $shippingMoney;
        return $this;
    }

    public function setReturnGoodsMoney($returnGoodsMoney){
        $this->model->return_goods_money = $returnGoodsMoney;
        return $this;
    }

    public function setOrderRemark($orderRemark){
        $this->model->order_remark = $orderRemark;
        return $this;
    }

    public function setBuyerAddress(\App\Models\BuyerAddressModel $model){
        $this->model->receive_province = $model->province;
        $this->model->receive_city = $model->city;
        $this->model->receive_area = $model->area;
        $this->model->receive_address = $model->address;
        $this->model->receive_postal_code = $model->receive_postal_code;
        $this->model->receive_name = $model->name;
        $this->model->receive_phone = $model->phone;
        return $this;
    }

    public function setTotalGrowth($totalGrowth){
        $this->model->total_growth = $totalGrowth;
        return $this;
    }

    public function setCoupan(\App\Models\CoupanModel $model){
        $this->model->coupon_id = $model->coupon_id;
        return $this;
    }

    public function setActivity(\App\Models\ActivityModel $model){
        $this->model->activity_id = $model->activity_id;
        return $this;
    }

    public function setCompleteTime(){
        $this->model->complete_time = date("Y-m-d H:i:s");
        return $this;
    }

    public function setShippingTime(){
        $this->model->shipping_time = date("Y-m-d H:i:s");
        return $this;
    }

    public function setPaymentTime(){
        $this->model->payment_time = date("Y-m-d H:i:s");
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

    public function setInvoiceNumber($invoiceNumber){
        $this->model->invoice_number = $invoiceNumber;
        return $this;
    }

    public function setAliPay(){
        $this->model->payment_method = \App\Models\OrderModel::aliPay;
        return $this;
    }

    public function setWxPay(){
        $this->model->payment_method = \App\Models\OrderSubModel::wxPay;
        return $this;
    }

    public function setBalancePay(){
        $this->model->payment_method = \App\Models\OrderSubModel::balancePay;
        return $this;
    }

    public function setOnlinePay(){
        $this->model->payment_method = \App\Models\OrderModel::onlinePay;
        return $this;
    }

    public function setAppSource(){
        $this->model->order_source = \App\Models\OrderModel::appSource;
        return $this;
    }

    public function setWapSource(){
        $this->model->order_source = \App\Models\OrderModel::wapSource;
        return $this;
    }

    public function setStatusActive(){
        $this->model->order_status = \App\Models\OrderSubModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->order_status = \App\Models\OrderSubModel::statusInactive;
        return $this;
    }

    public function setStatusSend(){
        $this->model->send_status = \App\Models\OrderSubModel::statusSend;
        return $this;
    }

    public function setStatusNoSend(){
        $this->model->send_status = \App\Models\OrderSubModel::statusNoSend;
        return $this;
    }

    public function setStatusPay(){
        $this->model->pay_status = \App\Models\OrderSubModel::statusPay;
        return $this;
    }

    public function setStatusNoPay(){
        $this->model->pay_status = \App\Models\OrderSubModel::statusNoPay;
        return $this;
    }

    public function setIsReceipt(){
        $this->model->receipt_status = \App\Models\OrderSubModel::isReceipt;
        return $this;
    }

    public function setNoReceipt(){
        $this->model->receipt_status = \App\Models\OrderSubModel::noReceipt;
        return $this;
    }

    public function setIsEvaluation(){
        $this->model->evaluation_status = \App\Models\OrderSubModel::isEvaluation;
        return $this;
    }

    public function setNoEvaluation(){
        $this->model->evaluation_status = \App\Models\OrderSubModel::noEvaluation;
        return $this;
    }

    public function setStatusRefund(){
        $this->model->refund_status = \App\Models\OrderSubModel::statusRefund;
        return $this;
    }

    public function setStatusNoRefund(){
        $this->model->refund_status = \App\Models\OrderSubModel::statusNoRefund;
        return $this;
    }

    public function setStatusReturnGoods(){
        $this->model->return_goods_status = \App\Models\OrderSubModel::statusReturnGoods;
        return $this;
    }

    public function setStatusNoReturnGoods(){
        $this->model->return_goods_status = \App\Models\OrderSubModel::statusNoReturnGoods;
        return $this;
    }

    public function setIsDeal(){
        $this->model->deal_status = \App\Models\OrderSubModel::isDeal;
        return $this;
    }

    public function setRefuseDeal(){
        $this->model->deal_status = \App\Models\OrderSubModel::refuseDeal;
    }

    public function setApplyDeal(){
        $this->model->deal_status = \App\Models\OrderSubModel::statusApplyDeal;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}