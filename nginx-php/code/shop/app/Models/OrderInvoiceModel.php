<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/20
 * Time: 17:37
 */

namespace App\Models;


class OrderInvoiceModel extends BaseModel
{
    protected $table = "order_invoice";
    protected $primaryKey = 'order_invoice_id';

    const electronicInvoice = 0;//电子发票
    const paperInvoice = 1;//纸质发票

    public function setInvoiceAttribute($value){
        if( $value == '电子发票' ){
            $this->attributes['invoice_type'] = self::electronicInvoice;
        }
        if( $value == '纸质发票' ){
            $this->attributes['invoice_type'] = self::paperInvoice;
        }
    }
}