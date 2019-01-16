<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28
 * Time: 15:29
 */

namespace App\Service\Api;


class BuyerAddressService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\BuyerAddressModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\BuyerAddressModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->name = $name;
        return $this;
    }

    public function setPhone($phone){
        $this->model->phone = $phone;
        return $this;
    }

    public function setPostalCode($postalCode){
        $this->model->receive_postal_code = $postalCode;
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

    public function setAddress($address){
        $this->model->address = $address;
        return $this;
    }

    public function setDelActive()
    {
        $this->model->del_status = \App\Models\BuyerAddressModel::delActive;
        return $this;
    }

    public function setDelInactive()
    {
        $this->model->del_status = \App\Models\BuyerAddressModel::delInactive;
        return $this;
    }

    public function setDefaultActive()
    {
        $this->model->is_default = \App\Models\BuyerAddressModel::defaultActive;
        return $this;
    }

    public function setDefaultInactive()
    {
        $this->model->is_default = \App\Models\BuyerAddressModel::defaultInactive;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}