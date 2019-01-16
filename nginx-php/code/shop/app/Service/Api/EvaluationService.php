<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/2
 * Time: 17:26
 */

namespace App\Service\Api;


class EvaluationService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\EvaluationModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\EvaluationModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setContent($content){
        $this->model->content = $content;
        return $this;
    }

    public function setImgUrl($imgUrl){
        $this->model->img_url = $imgUrl;
        return $this;
    }

    public function setOrderSub(\App\Models\OrderSubModel $model){
        $this->model->order_sn = $model->order_sn;
        $this->model->order_sub_sn = $model->order_sub_sn;
        return $this;
    }

    public function setSku(\App\Models\OrderDetailModel $model){
        $this->model->sku_code = $model->sku_code;
        return $this;
    }

    public function setBuyer(\App\Models\BuyerModel $model){
        $this->model->buyer_id = $model->buyer_id;
        return $this;
    }

    public function setProduct(\App\Models\ProductModel $model){
        $this->model->product_number = $model->product_number;
        return $this;
    }

    public function setBad()
    {
        $this->model->des_match = \App\Models\EvaluationModel::bad;
        return $this;
    }

    public function setNotGood()
    {
        $this->model->des_match = \App\Models\EvaluationModel::notGood;
        return $this;
    }

    public function setGeneral()
    {
        $this->model->des_match = \App\Models\EvaluationModel::general;
        return $this;
    }

    public function setGood()
    {
        $this->model->des_match = \App\Models\EvaluationModel::good;
        return $this;
    }

    public function setPerfect()
    {
        $this->model->des_match = \App\Models\EvaluationModel::perfect;
        return $this;
    }

    public function setHasImg()
    {
        $this->model->has_img = \App\Models\EvaluationModel::hasImg;
        return $this;
    }

    public function setNoImg()
    {
        $this->model->has_img = \App\Models\EvaluationModel::noImg;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}