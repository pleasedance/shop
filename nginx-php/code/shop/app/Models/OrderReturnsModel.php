<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/4
 * Time: 19:19
 */

namespace App\Models;


class OrderReturnsModel extends BaseModel
{
    protected $table = "order_returns";
    protected $primaryKey = 'order_return_sn';
    public $incrementing = false;//非递增或者非数字的主键
    protected $keyType = "string";//主键不是一个整数

    //禁止created_at
    //const CREATED_AT = NULL;

    //禁止update_at
    //const UPDATED_AT = NULL;

    const refunding = 0;//退款中
    const refunded = 1;//已退款

    const returnGoodsing = 0;//退货中
    const returnGoodsed = 1;//已退货
    const refuseDeal = 2;//拒绝
    const applyDeal = 3;//申请中

    public function orderReturnsDetail(){
        return $this->hasOne("App\Models\OrderReturnsDetailModel","order_return_sn","order_return_sn");
    }

    public function buyer(){
        return $this->belongsTo("App\Models\BuyerModel","buyer_id","buyer_id");
    }

    public function sellerAddress(){
        return $this->hasOne("App\Models\SellerAddressModel","id","seller_address_id");
    }

    public function product(){
        return $this->hasOne("App\Models\ProductModel","product_number","product_number");
    }
}