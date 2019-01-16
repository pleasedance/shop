<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 15:56
 */

namespace App\Models;


class SellerAuthenticationModel extends BaseModel
{
    protected $table = "seller_authentication";

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用
}