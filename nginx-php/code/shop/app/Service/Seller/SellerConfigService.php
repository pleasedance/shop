<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 13:54
 */

namespace App\Service\Seller;


class SellerConfigService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerConfigModel $model=NULL) {
        if(!$model){
            $model = new \App\Models\SellerConfigModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setSellerId($sellerId){
        $this->model->seller_id = $sellerId;
        return $this;
    }

    public function setConfigItem($configItem){
        $this->model->config_item = $configItem;
        return $this;
    }

    public function setConfigValue($configValue){
        $this->model->config_value = $configValue;
        return $this;
    }

    public function setSort($sort){
        $this->model->sort = $sort;
        return $this;
    }

    public function setRemark($remark){
        $this->model->remark = $remark;
        return $this;
    }
    public function setDelActive(){
        $this->model->del_status=\App\Models\SellerConfigModel::delActive;
        return $this;
    }
    public function save(){
        $this->model->save();
        return $this->model;
    }
}