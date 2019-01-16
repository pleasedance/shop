<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Seller;

/**
 * Description of MainService
 *
 * @author Administrator
 */
class MainService {
    
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\SellerModel();
//            $model->from= \App\Models\SellerModel::fromExcel;
            $this->create=TRUE;
        }
        $this->model=$model;
        $this->model->status = 1;
        return $this;
    }
    
    public function setRealname($realname){
        $this->model->real_name=$realname;
        return $this;
    }
    
    public function setSource($source){
        $this->model->source=$source;
        return $this;
    }

    public function setProvince($province){
        $this->model->province=$province;
        return $this;
    }

    public function setCity($city){
        $this->model->city=$city;
        return $this;
    }

    public function setArea($area){
        $this->model->area=$area;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        return $this->model;
    }
    
}
