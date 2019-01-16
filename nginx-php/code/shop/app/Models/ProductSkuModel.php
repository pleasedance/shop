<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 17:42
 */

namespace App\Models;


class ProductSkuModel extends BaseModel
{
    protected $table = "pd_product_sku";

    const multY = 1;//多选
    const multN = 1;//单选

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}