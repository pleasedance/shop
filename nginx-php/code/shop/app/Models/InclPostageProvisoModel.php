<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 13:21
 */

namespace App\Models;


class InclPostageProvisoModel extends BaseModel
{
    protected $table = "seller_incl_postage_proviso";

    //禁止update_at
    const UPDATED_AT = NULL;
}