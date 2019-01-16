<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 10:00
 */

namespace App\Models;


class BuyerModel extends BaseModel
{
    protected $table = "buyer_user";
    protected $primaryKey = 'buyer_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用

    const sexMan = 0;//男
    const sexWoman = 1;//女
    const sexSecrecy = 2;//保密

    public function depart()
    {
        return $this->hasOne("App\Models\DepartModel","depart_id","depart_id");
    }

    public function company()
    {
        return $this->hasOne("App\Models\CompanyModel","company_id","company_id");
    }

    public function getSexAttribute()
    {
        return ($this->attributes['sex']==0)?"男":"女";
    }
}