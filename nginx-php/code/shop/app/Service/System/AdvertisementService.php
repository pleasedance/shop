<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9
 * Time: 19:34
 */

namespace App\Service\System;


class AdvertisementService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\AdvertisementModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\AdvertisementModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setName($name){
        $this->model->ad_name=$name;
        return $this;
    }

    public function setXiaochengxu(){
        $this->model->ad_position=\App\Models\AdvertisementModel::xiaochengxu;
        return $this;
    }

    public function setTypeNotxiaochengxu(){
        $this->model->type=\App\Models\AdvertisementModel::notxiaochengxu;
        return $this;
    }

    public function setTypexiaochengxu(){
        $this->model->type=\App\Models\AdvertisementModel::xiaochengxu;
        return $this;
    }

    public function setAdPicture($img){
        $this->model->ad_picture=$img;
        return $this;
    }

    public function setStart(){
        $this->model->start_status=\App\Models\AdvertisementModel::start;
        return $this;
    }

    public function setNoStart(){
        $this->model->start_status=\App\Models\AdvertisementModel::nostart;
        return $this;
    }

    public function setClickCount(){
        $this->model->click_count=$this->model->click_count+1;
        return $this;
    }

    public function setAdUrl($url){
        $this->model->ad_url=$url;
        return $this;
    }

    public function setRemarks($remarks){
        $this->model->remarks=$remarks;
        return $this;
    }

    public function setStartTime($startTime){
        $this->model->start_time=$startTime;
        return $this;
    }

    public function setEndTime($endTime){
        $this->model->end_time=$endTime;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\AdvertisementModel::delActive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}