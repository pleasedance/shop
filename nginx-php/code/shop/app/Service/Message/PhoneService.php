<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\Message;

/**
 * 发送手机短信
 *
 * @author Administrator
 */
class PhoneService {
    
    
    private $model;
    public function __construct(\App\Models\PhoneMessageModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\PhoneMessageModel();
            $model->status= \App\Models\PhoneMessageModel::statusInit;
        }
        $this->model=$model;
        return $this;
    }
    
    /**
     * 设置手机号
     * @param type $mobile
     * @return $this
     */
    public function setMobile($mobile){
        $this->model->mobile=$mobile;
        return $this;
    }
    
    /**
     * 指定商户
     * @param \App\Models\CompanyModel $compamyModel
     * @return $this
     */
    public function setCompanyModel(\App\Models\CompanyModel $compamyModel){
        $this->model->company_id=$compamyModel->id;
        if($compamyModel->sms && $compamyModel->sms->sign){
            $this->setSign($compamyModel->sms->sign);
        }else{
            $this->setSign(45581);
        }
        return $this;
    }
    
    /**
     * 设置签名
     * @param type $sign
     * @return $this
     */
    public function setSign($sign){
        $this->model->sign=$sign;
        return $this;
    }
    
    /**
     * 设置文本
     * @param type $text
     * @return $this
     */
    public function setText($text){
        $this->model->text=$text;
        return $this;
    }
    
    /**
     * 设置模板
     * @param type $tmp
     * @return $this
     */
    public function setTmp($tmp){
        $this->model->tmp_id=$tmp;
        return $this;
    }
    
    /**
     * 设置参数
     * @param type $param
     * @return $this
     */
    public function setParam($param){
        $this->model->param=$param;
        return $this;
    }
    
    public function save(){
        if($this->model->company_id){
            $companyModel= \App\Data\CompanyData::info($this->model->company_id);
            $server=new \App\Service\Company\SmsStatementService();
            $server->setCompany($companyModel);
            $server->setType(\App\Models\CompanySmsStatementModel::typeDec);
            $server->setRemark("发短信扣除");
            $statementModel=$server->save();
            $this->model->statement_id=$statementModel->id;
        }
        $this->model->save();
        \App\Jobs\Message\Phone::dispatch(["model"=> $this->model]);    //推送消息队列
        return $this->model;
    }
    
    /**
     * 短信发送成功
     * @param type $result
     * @return type
     */
    public function success($result){
        $this->model->status= \App\Models\PhoneMessageModel::statusSuccess;
        $this->model->result=$result;
        $this->model->save();
        return $this->model;
    }
    
    /**
     * 短信发送失败
     * @param type $result
     * @return type
     */
    public function fail($result){
        if($this->model->company_id && $this->model->statement_id){
            $companyModel= \App\Data\CompanyData::info($this->model->company_id);
            $server=new \App\Service\Company\SmsStatementService();
            $server->setCompany($companyModel);
            $server->setType(\App\Models\CompanySmsStatementModel::typeInc);
            $server->setRemark("短信发送失败归还");
            $server->save();
        }
        $this->model->status= \App\Models\PhoneMessageModel::statusFail;
        $this->model->result=$result;
        $this->model->save();
        return $this->model;
    }
    
}
