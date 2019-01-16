<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/12
 * Time: 14:48
 */

namespace App\Service\Seller;


class CategoryParamPropertiesService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\CategoryParamPropertiesModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\CategoryParamPropertiesModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setCategoryParamProperties($model){
        $this->model->param_number=$model->param_number;
        $this->model->param_name=$model->param_name;
        return $this;
    }

    public function setParamPropertieValue($paramPropertieValue){
        $this->model->param_propertie_value=$paramPropertieValue;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}