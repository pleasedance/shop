<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/20
 * Time: 17:35
 */

namespace App\Models;


class OrderDetailModel extends BaseModel
{
    protected $table = "order_detail";
    protected $primaryKey = 'order_detail_id';

    public function order()
    {
        return $this->belongsTo("App\Models\OrderModel","order_sn","order_sn");
    }

    public function orderSub()
    {
        return $this->hasOne("App\Models\OrderSubModel","order_sub_sn","order_sub_sn");
    }

    public function skuProperties()
    {
        return $this->hasOne("App\Models\SkuPropertiesModel","sku_code","sku_code");
    }

    public function product()
    {
        return $this->hasOne("App\Models\ProductModel","product_number","product_number")->select(["product_number","market_price"]);
    }
}