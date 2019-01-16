<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/27
 * Time: 15:51
 */

namespace App\Service\Seller;


class BrandService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\BrandModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\BrandModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setBrandName($brandName){
        $this->model->brand_name=$brandName;
        return $this;
    }

    public function setBrandInitials($brandInitials){
        $this->model->brand_initials=$brandInitials;
        return $this;
    }

    public function setBrandLogoUrl($brandLogoUrl){
        $this->model->brand_logo_url=$brandLogoUrl;
        return $this;
    }

    public function setBrandDetailUrl($brandDetailUrl){
        $this->model->brand_detail_url=$brandDetailUrl;
        return $this;
    }

    public function setBrandIntroduce($brandIntroduce){
        $this->model->brand_introduce=$brandIntroduce;
        return $this;
    }

    public function setSort($sort){
        $this->model->sort=$sort;
        return $this;
    }

    public function setIsShow(){
        $this->model->is_show=\App\Models\BrandModel::isShow;
        return $this;
    }

    public function setNoShow(){
        $this->model->is_show=\App\Models\BrandModel::noShow;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\BrandModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\BrandModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}