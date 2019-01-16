<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 13:21
 */

namespace App\Models;


class SellerInclPostageProvisoModel extends BaseModel
{
    protected $table = "seller_incl_postage_proviso";
    public $timestamps = false;

    //禁止update_at
    public function getUpdatedAtColumn() {
        return null;
    }
}