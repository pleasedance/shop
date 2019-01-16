<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 13:51
 */

namespace App\Models;


class SellerConfigModel extends BaseModel
{
    protected $table = "seller_config";
    protected $primaryKey = 'config_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}