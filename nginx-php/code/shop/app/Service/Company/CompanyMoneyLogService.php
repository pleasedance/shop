<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 17:23
 */

namespace App\Service\Company;


class CompanyMoneyLogService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CompanyMoneyLogModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CompanyMoneyLogModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setComany(\App\Models\CompanyModel $model){
        $this->model->company_id = $model->company_id;
        return $this;
    }

    public function setMoney($money){
        $this->model->money = $money;
        return $this;
    }

    public function setRemark($remark){
        $this->model->remark = $remark;
        return $this;
    }

    public function setIp()
    {
        $this->model->ip = \DataBaseHelper::getIp();
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}