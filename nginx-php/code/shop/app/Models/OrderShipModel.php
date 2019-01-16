<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/7
 * Time: 16:58
 */

namespace App\Models;


class OrderShipModel extends BaseModel
{
    protected $table = "order_ship";
    protected $primaryKey = 'order_ship_sn';
    public $incrementing = false;//非递增或者非数字的主键
    protected $keyType = "string";//主键不是一个整数
}