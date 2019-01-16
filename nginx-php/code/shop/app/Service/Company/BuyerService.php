<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 10:23
 */

namespace App\Service\Company;


class BuyerService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\BuyerModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\BuyerModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setBuyerAddress(\App\Models\BuyerAddressModel $model){
        $this->model->buyer_address_id = $model->id;
        return $this;
    }

    public function setLoginid($loginid){
        $this->model->loginid = $loginid;
        return $this;
    }

//    public function setPassword($password){
//        $this->model->password = \DataBaseHelper::setPassword($password);
//        return $this;
//    }

    public function setName($name){
        $this->model->real_name = $name;
        return $this;
    }

    public function setJobNumber($jobNumber){
        $this->model->job_number = $jobNumber;
        return $this;
    }

    public function setPhone($phone){
        $this->model->phone = $phone;
        return $this;
    }

    public function setProvince($province){
        $this->model->province = $province;
        return $this;
    }

    public function setHeadImg($img){
        $this->model->head_img = $img;
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

    public function setInviteUser($inviteUser){
        $this->model->invite_user = $inviteUser;
        return $this;
    }

    public function setDepart(\App\Models\DepartModel $model){
        $this->model->depart_id = $model->depart_id;
        return $this;
    }

    public function setSource($source){
        $this->model->source = $source;
        return $this;
    }

    public function setWechat($wechat){
        $this->model->wechat_openid = $wechat;
        return $this;
    }

    public function setQQ($QQ){
        $this->model->qq_openid = $QQ;
        return $this;
    }

    public function setCompany(\App\Models\CompanyModel $model){
        $this->model->company_id = $model->company_id;
        return $this;
    }

    public function setMoney($money){
        $this->model->money += $money;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\BuyerModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\BuyerModel::statusInactive;
        return $this;
    }

    public function sexMan()
    {
        $this->model->sex=\App\Models\BuyerModel::sexMan;
        return $this;
    }

    public function sexWoman()
    {
        $this->model->sex=\App\Models\BuyerModel::sexWoman;
        return $this;
    }

    public function sexSecrecy()
    {
        $this->model->sex=\App\Models\BuyerModel::sexSecrecy;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}