<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 13:11
 */

namespace App\Models;


class FareTemplateModel extends BaseModel
{
    protected $table = "seller_fare_template";
    protected $primaryKey = 'tpl_id';

    const isExemption = 0;//自定义运费
    const noExemption = 1;//卖家承担运费

    const numberType = 0;//按件计费
    const weightType = 1;//按重量计费
    const volumeType = 2;//按体积

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const isRequirement = 1;//指定条件包邮
    const noRequirement = 0;//未指定条件包邮

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    public function carryMode(){
        return $this->hasMany("App\Models\CarryModeModel","tpl_id","tpl_id");
    }

    public function incPostageProviso(){
        return $this->hasMany("App\Models\InclPostageProvisoModel","tpl_id","tpl_id");
    }
}