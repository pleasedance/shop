<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9
 * Time: 11:30
 */

namespace App\Models;


class OrderReturnsDetailModel extends BaseModel
{
    protected $table = "order_returns_detail";

    public $timestamps = false;

    public function properties()
    {
        return $this->hasOne("App\Models\SkuPropertiesModel","sku_code","sku_code")->select(["sku_picture_url"]);
    }
}