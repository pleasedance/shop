<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/3
 * Time: 10:08
 */

namespace App\Service\Api;


class EvaluationReplyService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\EvaluationReplyModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\EvaluationReplyModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setContent($content){
        $this->model->content = $content;
        return $this;
    }

    public function setEvaluation(\App\Models\EvaluationModel $model){
        $this->model->evaluation_id = $model->evaluation_id;
        return $this;
    }

    public function setSeller(\App\Models\SellerModel $model){
        $this->model->seller_id = $model->seller_id;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}