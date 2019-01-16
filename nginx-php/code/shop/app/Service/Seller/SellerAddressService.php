<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 10:14
 */

namespace App\Service\Seller;


class SellerAddressService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerAddressModel $model=NULL) {
        if(!$model){
            $model = new \App\Models\SellerAddressModel();
            $this->create=TRUE;
        }
        $this->model=$model;
//        $this->model->del_status = \App\Models\SellerAddressModel::delInactive;
//        $this->model->is_default = \App\Models\SellerAddressModel::defaultInactive;
        return $this;
    }

    public function setReceiveName($receiveName){
        $this->model->receive_name = $receiveName;
        return $this;
    }

    public function setReceivePhone($receivePhone){
        $this->model->receive_phone = $receivePhone;
        return $this;
    }

    public function setReceiveAddress($receiveAddress){
        $this->model->receive_address = $receiveAddress;
        return $this;
    }

    public function setPostNumber($postNumber){
        $this->model->post_number = $postNumber;
        return $this;
    }

    public function setProvince($province){
        $this->model->province = $province;
        return $this;
    }

    public function setCity($city){
        $this->model->city = $city;
        return $this;
    }

    public function setArea($area){
        $this->model->area = $area;
        return $this;
    }

    public function setSellerId($sellerId){
        $this->model->seller_id = $sellerId;
        return $this;
    }

    public function setSellerPhone($sellerPhone){
        $this->model->seller_phone = $sellerPhone;
        return $this;
    }

    public function setSellerRealName($sellerRealName){
        $this->model->seller_real_name = $sellerRealName;
        return $this;
    }

    public function setSellerUserName($sellerUserName){
        $this->model->seller_user_name = $sellerUserName;
        return $this;
    }
    public function setDefault($default){
        $this->model->is_default = $default;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}