<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Import;

/**
 * Description of MainService
 *
 * @author Administrator
 */
class MainService {
    
    private $model;
    public function __construct(\App\Models\ImportModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\ImportModel();
            $model->status= \App\Models\ImportModel::statusInit;
        }
        $this->model=$model;
        return $this;
    }
    
    public function setModule($module){
        $this->model->module=$module;
        return $this;
    }
    
    public function setFile($file){
        $this->model->file=$file;
        return $this;
    }
    
    public function setAdmin(\App\Models\AdminModel $adminModel){
        $this->model->admin_id=$adminModel->id;
        return $this;
    }
    
    public function save(){
        $this->model->save();
        \App\Jobs\Import::dispatch(["model"=> $this->model]);    //推送消息队列
        return $this->model;
    }
    
    public function success(){
        $this->model->status=\App\Models\ImportModel::statusSuccess;
        $this->model->save();
        return $this->model;
    }
    
    public function fail($message){
        $this->model->status=\App\Models\ImportModel::statusFail;
        $this->model->error=$message;
        $this->model->save();
        return $this->model;
    }
    
    
    public function import(){
        $file= \FileHelper::getFileHDPath($this->model->file, \FileHelper::nameSpaceExcel)."/".$this->model->file;
        try{
            $list= \FileHelper::readXslx($file);
        } catch (\Exception $ex){
            $this->fail($ex->getMessage());
            return $this->model;
        }
        \DB::beginTransaction();
        try {
            switch($this->model->module){
                case \App\Models\ImportModel::moduleUser:
                    $this->user($list);
                    break;
            }
            $this->success();
            \DB::commit();
        } catch (\Exception $exc) {
            \DB::rollback();
            $this->fail($exc->getMessage());
        }
    }
    
    /**
     * 导入用户
     * @param type $list
     * @throws \App\Exceptions\AppException
     */
    private function user($list){
        $adminModel=NULL;
        if($this->model->admin_id){
            $adminModel= \App\Data\AdminData::info($this->model->admin_id);
        }
        foreach ($list as $value){
            $realName= trim(array_get($value,"姓名",""));
            $mobile= trim(array_get($value,"手机号",""));
            $idCard= trim(array_get($value,"身份证",""));
            $brank= trim(array_get($value,"银行卡",""));
            if(!empty($mobile) || !empty($realName)){
                if(empty($mobile)){
                    throw new \App\Exceptions\AppException($realName."缺少手机号");
                }
                if(!\ValidateHelper::isMobile($mobile)){
                    throw new \App\Exceptions\AppException($mobile."手机号格式错误");
                }
                if(empty($realName)){
                    throw new \App\Exceptions\AppException($realName."缺少姓名");
                }
                $server=new \App\Service\User\MainService();
                $server->setRealname($realName);
                $server->setMobile($mobile);
                $server->setAdmin($adminModel);
                $server->setBrank($brank);
                $server->setIdCard($idCard);
                $server->save();
            }
        }
    }
    
}
