<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 14:34
 */

namespace App\Service\Seller;


class SellerService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerModel $model=NULL) {
        if(!$model){
            $model = new \App\Models\SellerModel();
//            $model->from= \App\Models\SellerModel::fromExcel;
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setStatusActive()
    {
        $this->model->status = \App\Models\SellerModel::statusActive;
        return $this;
    }

    public function setStatusInactive()
    {
        $this->model->status = \App\Models\SellerModel::statusInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}