<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 17:41
 */

namespace App\Service\Seller;


class CarryModeService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CarryModeModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CarryModeModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setTpl(\App\Models\FareTemplateModel $model){
        $this->model->tpl_id=$model->tpl_id;
        return $this;
    }

    public function setArea($area){
        $this->model->area=$area;
        return $this;
    }

    public function setBasicsWeight($basicsweight){
        $this->model->basics_weight=$basicsweight;
        return $this;
    }

    public function setBasicsNumber($basicsNumber){
        $this->model->basics_number=$basicsNumber;
        return $this;
    }

    public function setBasicsVolume($basicsVolume){
        $this->model->basics_volume=$basicsVolume;
        return $this;
    }

    public function setBasicsPrice($basicsPrice){
        $this->model->basics_price=$basicsPrice;
        return $this;
    }

    public function setExtraWeight($extraWeight){
        $this->model->extra_weight=$extraWeight;
        return $this;
    }

    public function setExtraNumber($extraNumber){
        $this->model->extra_number=$extraNumber;
        return $this;
    }

    public function setExtraVolume($extraVolume){
        $this->model->extra_volume=$extraVolume;
        return $this;
    }

    public function setExtraPrice($extraPrice){
        $this->model->extra_price=$extraPrice;
        return $this;
    }

    public function setDefaultActive(){
        $this->model->default_status=\App\Models\CarryModeModel::defaultActive;
        return $this;
    }

    public function setDefaultInactive(){
        $this->model->default_status=\App\Models\CarryModeModel::defaultInactive;
        return $this;
    }

    public function setExpressTransfer(){
        $this->model->transfer_type=\App\Models\CarryModeModel::expressTransfer;
        return $this;
    }

    public function setEmsTransfer(){
        $this->model->transfer_type=\App\Models\CarryModeModel::emsTransfer;
        return $this;
    }

    public function setPlainTransfer(){
        $this->model->transfer_type=\App\Models\CarryModeModel::plainTransfer;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}