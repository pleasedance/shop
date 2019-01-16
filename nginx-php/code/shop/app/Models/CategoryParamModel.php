<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/9
 * Time: 13:32
 */

namespace App\Models;


class CategoryParamModel extends BaseModel
{
    protected $table = "pd_product_param";
    protected $primaryKey = 'param_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const searchActive = 1;//可以进行检索
    const searchInactive = 0;//不可以进行检索

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    const showNavigation = 1;//导航栏显示
    const noshowNavigation = 0;//导航栏不显示

    public function category(){
        return $this->belongsTo("App\Models\CategoryModel","category_id","category_id");
    }

    public function categoryProperties(){
        return $this->hasMany("App\Models\CategoryParamPropertiesModel","param_number","param_number");
    }
}