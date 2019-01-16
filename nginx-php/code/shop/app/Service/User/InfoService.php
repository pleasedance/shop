<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\User;

/**
 * Description of InfoService
 *
 * @author Administrator
 */
class InfoService {
    
    private $model;
    public function __construct(\App\Models\UserModel $userModel=NULL) {
        $model=$userModel->info;
        if(!$model){
            $model=new \App\Models\UserInfoModel();
            $model->user_id=$userModel->id;
        }
        $this->model=$model;
        return $this;
    }
    
    /**
     * 正面照
     * @param type $face
     * @return $this
     */
    public function setFace($face){
        $this->model->face=$face;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        return $this;
    }
}
