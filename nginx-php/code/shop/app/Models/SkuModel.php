<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 10:27
 */

namespace App\Models;


class SkuModel extends BaseModel
{
    protected $table="pd_sku";
    protected $primaryKey = 'sku_id';
    public $timestamps = false;

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function product(){
        return $this->belongsTo("App\Models\ProductModel","product_number","product_number");
    }

    public function skuProperties(){
        //\App\Models\SkuModel::Class
        return $this->belongsToMany("App\Models\SkuPropertiesModel","pd_sku_properties","sku_id","sku_unique_code");
    }
}