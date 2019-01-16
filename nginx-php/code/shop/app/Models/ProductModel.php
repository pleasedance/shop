<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 10:15
 */

namespace App\Models;


class ProductModel extends BaseModel
{
    protected $table="pd_product";
    protected $primaryKey = 'product_id';

    const isSell = 1;        //上架
    const noSell = 2;        //未上架

    const wuyouService = 0;        //无忧退货
    const kuaisuService = 1;        //快速退款
    const mianfeiService = 2;        //免费包邮

    const verifyActive = 1; //已审核
    const verifyInactive = 0;   //未审核

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function sku(){
        return $this->hasMany("App\Models\SkuModel","product_number","product_number");
    }

    public function skuProperties(){
        return $this->hasMany("App\Models\SkuPropertiesModel","product_number","product_number");
    }
}