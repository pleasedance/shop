<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 17:58
 */

namespace App\Models;


class BrandModel extends BaseModel
{
    protected $table = "pd_product_brand";
    protected $primaryKey = 'brand_id';

    const isShow = 1;//显示
    const noShow = 0;//不显示

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}