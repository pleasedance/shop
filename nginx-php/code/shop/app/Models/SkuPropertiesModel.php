<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/20
 * Time: 10:29
 */

namespace App\Models;


class SkuPropertiesModel extends BaseModel
{
    protected $table="pd_sku_properties";
    protected $primaryKey = 'properties_id';
    public $timestamps = false;
}