<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 18:08
 */

namespace App\Service\Seller;


class InclPostageProvisoService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\InclPostageProvisoModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\InclPostageProvisoModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setTpl(\App\Models\FareTemplateModel $model){
        $this->model->tpl_id=$model->tpl_id;
        return $this;
    }

    public function setArea($area){
        $this->model->area=$area;
        return $this;
    }

    public function setNum($num){
        $this->model->num=$num;
        return $this;
    }

    public function setWeight($weight){
        $this->model->weight=$weight;
        return $this;
    }

    public function setVolume($volume){
        $this->model->volume=$volume;
        return $this;
    }

    public function setMoney($money){
        $this->model->money=$money;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}