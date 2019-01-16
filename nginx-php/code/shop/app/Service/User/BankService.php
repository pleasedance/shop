<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\User;

/**
 * Description of BankService
 *
 * @author Administrator
 */
class BankService {
    
    
    private $model;
    public function __construct(\App\Models\BankModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\BankModel();
        }
        $this->model=$model;
        return $this;
    }
    
    public function setCode($code){
        $this->model->code=$code;
        return $this;
    }
    
    public function setType($type){
        $this->model->type=$type;
        return $this;
    }
    
    public function setIdCard($idCard){
        $this->model->id_card=$idCard;
        return $this;
    }
    
    public function setPhone($phone){
        $this->model->phone=$phone;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        return $this;
    }
}
