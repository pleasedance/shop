<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 10:51
 */

namespace App\Service\Seller;


class ProductService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\ProductModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\ProductModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        return $this;
    }

    public function setProductArtNo($productSrtNo){
        $this->model->product_art_no = $productSrtNo;
        return $this;
    }
    
    public function setProductNumber($productNumber){
        $this->model->product_number = $productNumber;
        return $this;
    }

    public function setName($name){
        $this->model->pd_name = $name;
        return $this;
    }

    public function setSubtitle($subtitle){
        $this->model->pd_subtitle = $subtitle;
        return $this;
    }

    public function setDescs($descs){
        $this->model->pd_descs = $descs;
        return $this;
    }

    public function setCategoryId($categoryId){
        $this->model->pd_category_id = $categoryId;
        return $this;
    }

    public function setSellerId($sellerId){
        $this->model->pd_seller_id = $sellerId;
        return $this;
    }

    public function setBrandId($brandId){
        $this->model->pd_brand_id = $brandId;
        return $this;
    }

    public function setExpressTplId($expressTplId){
        $this->model->express_tpl_id = $expressTplId;
        return $this;
    }

    public function setUnit($unit){
        $this->model->pd_unit = $unit;
        return $this;
    }

    public function setWeight($weight){
        $this->model->pd_weight = $weight;
        return $this;
    }

    public function setWeightUnit($weightUnit){
        $this->model->pd_weight_unit = $weightUnit;
        return $this;
    }

    public function setVolume($volume){
        $this->model->pd_volume = $volume;
        return $this;
    }

    public function setVolumeUnit($volumeUnit){
        $this->model->pd_volume_unit = $volumeUnit;
        return $this;
    }

    public function setIsSell(){
        $this->model->pd_is_sell = \App\Models\ProductModel::isSell;
        return $this;
    }

    public function setMarketPrice($marketPrice){
        $this->model->market_price = $marketPrice;
        return $this;
    }

    public function setMemberPrice($memberPrice){
        $this->model->member_price = $memberPrice;
        return $this;
    }

    public function setMinPrice($minPrice){
        $this->model->min_price = $minPrice;
        return $this;
    }

    public function setSalesNum($num){
        $this->model->sales_num = $num;
        return $this;
    }

    public function setNoSell(){
        $this->model->pd_is_sell = \App\Models\ProductModel::noSell;
        return $this;
    }

    public function setRecommendType($recommendType){
        $this->model->pd_recommend_type = $recommendType;
        return $this;
    }

    public function setServiceGuaranTee($serviceGuaranTee){
        $this->model->pd_service_guarantee = $serviceGuaranTee;
        return $this;
    }

    public function setDetailDescr($detailDescr){
        $this->model->detail_descr = $detailDescr;
        return $this;
    }

    public function setKeyWord($keyWord){
        $this->model->pd_key_word = $keyWord;
        return $this;
    }

    public function setRemark($remark){
        $this->model->pd_remark = $remark;
        return $this;
    }

    public function setPicturePrefix($picturePrefix){
        $this->model->pd_picture_prefix = $picturePrefix;
        return $this;
    }

    public function setDetailInfo($detailInfo){
        $this->model->pd_detail_info = $detailInfo;
        return $this;
    }

    public function setPdImageUrl($pdImageUrl){
        $this->model->pd_image_url = $pdImageUrl;
        return $this;
    }

    public function setPdTranslationPic($pdTranslationPic){
        $this->model->pd_translation_pic = $pdTranslationPic;
        return $this;
    }

    public function setSort($sort){
        $this->model->pd_sort = $sort;
        return $this;
    }

    public function setVerifyActive(){
        $this->model->verify_status = \App\Models\ProductModel::verifyActive;
        return $this;
    }

    public function setVerifyInactive(){
        $this->model->verify_status = \App\Models\ProductModel::verifyInactive;
        return $this;
    }

    public function setDetailTitle($detailTitle){
        $this->model->detail_title = $detailTitle;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status = \App\Models\ProductModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status = \App\Models\ProductModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}