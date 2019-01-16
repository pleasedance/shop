<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14
 * Time: 16:24
 */

namespace App\Models;


class CartModel extends BaseModel
{
    protected $table = "pd_shopping_cart";
    protected $primaryKey = 'cart_id';

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function product()
    {
        return $this->hasOne('App\Models\ProductModel','product_number','product_number');
    }

    public function properties()
    {
        return $this->hasOne('App\Models\SkuPropertiesModel','sku_code','sku_code');
    }

    public function sku()
    {
        return $this->hasOne('App\Models\SkuModel','sku_code','sku_code')->select(["sku_code","property"]);
    }
}