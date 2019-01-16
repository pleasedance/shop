<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 15:58
 */

namespace App\Service\Seller;


class FareTemplateService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\FareTemplateModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\FareTemplateModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setTplName($tplname){
        $this->model->tpl_name=$tplname;
        return $this;
    }

    public function setAddress($address){
        $this->model->address=$address;
        return $this;
    }

    public function setSendTime($sendTime){
        $this->model->send_time=$sendTime;
        return $this;
    }

    public function setSellerId($sellerId){
        $this->model->seller_id=$sellerId;
        return $this;
    }

    public function setIsExemption(){
        $this->model->exemption_status=\App\Models\FareTemplateModel::isExemption;
        return $this;
    }

    public function setNoExemption(){
        $this->model->exemption_status=\App\Models\FareTemplateModel::noExemption;
        return $this;
    }

    public function setNumberType(){
        $this->model->pricing_model_type=\App\Models\FareTemplateModel::numberType;
        return $this;
    }

    public function setWeightType(){
        $this->model->pricing_model_type=\App\Models\FareTemplateModel::weightType;
        return $this;
    }

    public function setVolumeType(){
        $this->model->pricing_model_type=\App\Models\FareTemplateModel::volumeType;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\FareTemplateModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\FareTemplateModel::statusInactive;
        return $this;
    }

    public function setIsRequirement(){
        $this->model->requirement_status=\App\Models\FareTemplateModel::isRequirement;
        return $this;
    }

    public function setNoRequirement(){
        $this->model->requirement_status=\App\Models\FareTemplateModel::noRequirement;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\FareTemplateModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\FareTemplateModel::delInactive;
        return $this;
    }

    //新增运送方式
    public function setTransferType(\App\Models\FareTemplateModel $model,$param)
    {
        $server = new \App\Service\Seller\CarryModeService();
        $server->setTpl($model);
        $server->setArea($param['area']);
        $server->setBasicsWeight($param['basics_weight']);
        $server->setBasicsNumber($param['basics_number']);
        $server->setBasicsVolume($param['basics_volume']);
        $server->setBasicsPrice($param['basics_price']);
        $server->setExtraWeight($param['extra_weight']);
        $server->setExtraNumber($param['extra_number']);
        $server->setExtraVolume($param['extra_volume']);
        $server->setExtraPrice($param['extra_price']);
        $server->setDefaultInactive();
        switch ($param['transfer_type']){
            case "0":
                $server->setExpressTransfer();
                break;
            case "1":
                $server->setEmsTransfer();
                break;
            case "2":
                $server->setPlainTransfer();
                break;
        }
        $carryModeModel = $server->save();
        return $carryModeModel;
    }

    //新增包邮条件
    public function setInclPostageProviso(\App\Models\FareTemplateModel $model,$param)
    {
        $server = new \App\Service\Seller\InclPostageProvisoService();
        $server->setTpl($model);
        $server->setArea($param['incl_areas']);
        $server->setNum($param['num']);
        $server->setWeight($param['weight']);
        $server->setVolume($param['volume']);
        $server->setMoney($param['money']);
        $inclPostageProviso = $server->save();
        return $inclPostageProviso;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }

}