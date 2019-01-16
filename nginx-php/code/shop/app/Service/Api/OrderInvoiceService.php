<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/21
 * Time: 14:27
 */

namespace App\Service\Api;


class OrderInvoiceService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\OrderInvoiceModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\OrderInvoiceModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setOrderSn($orderSn){
        $this->model->order_sn = $orderSn;
        return $this;
    }

    public function setInvoiceNumber($invoiceNumber){
        $this->model->invoice_number = $invoiceNumber;
        return $this;
    }

    public function setElectronicInvoice(){
        $this->model->invoice_type = \App\Models\OrderInvoiceModel::electronicInvoice;
    }

    public function setPaperInvoice(){
        $this->model->invoice_type = \App\Models\OrderInvoiceModel::paperInvoice;
    }

    public function setInvoiceTitle($invoiceTitle){
        $this->model->invoice_title = $invoiceTitle;
        return $this;
    }

    public function setInvoiceContent($invoiceContent){
        $this->model->invoice_content = $invoiceContent;
        return $this;
    }

    public function setInvoiceUserPhone($invoiceUserPhone){
        $this->model->invoice_user_phone = $invoiceUserPhone;
        return $this;
    }

    public function setInvoiceUserEmail($invoiceUserEmail){
        $this->model->invoice_user_email = $invoiceUserEmail;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}