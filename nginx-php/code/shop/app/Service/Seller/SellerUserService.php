<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 15:25
 */

namespace App\Service\Seller;


class SellerUserService
{

    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerUserModel $model=NULL) {
        if(!$model){
            $model = new \App\Models\SellerUserModel();
//            $model->from= \App\Models\SellerModel::fromExcel;
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setSeller(\App\Models\SellerModel $sellerModel){
        $this->model->seller_id = $sellerModel->seller_id;
        $this->model->real_name = $sellerModel->real_name;
        return $this;
    }

    public function setPassword($password){
        $this->model->password = $password;
        return $this;
    }

    public function setLoginId($loginId){
        $this->model->loginid = $loginId;
        return $this;
    }

    public function setPhone($phone){
        $this->model->phone = $phone;
        return $this;
    }

    public function setSource($source){
        $this->model->source = $source;
        return $this;
    }

    public function setMan(){
        $this->model->sex = \App\Models\SellerUserModel::sexMan;
        return $this;
    }

    public function setWoman(){
        $this->model->sex = \App\Models\SellerUserModel::sexWoman;
        return $this;
    }

    public function setSecrecy(){
        $this->model->sex = \App\Models\SellerUserModel::sexSecrecy;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }

}