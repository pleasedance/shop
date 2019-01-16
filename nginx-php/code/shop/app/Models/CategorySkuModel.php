<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 10:06
 */

namespace App\Models;


class CategorySkuModel extends BaseModel
{
    protected $table = "pd_category_sku";
    protected $primaryKey = 'propertie_id';

    const multChooseActive = 1;//可以多选
    const multChooseInactive = 0;//不可以多选

    const searchActive = 1;//可以进行检索
    const searchInactive = 0;//不可以进行检索

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function category(){
        return $this->belongsTo("App\Models\CategoryModel","category_id","category_id");
    }

    public function categorySkuProperties(){
        return $this->hasMany("App\Models\CategorySkuPropertiesModel","sku_number","sku_number");
    }
}