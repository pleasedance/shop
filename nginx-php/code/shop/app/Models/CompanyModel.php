<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 18:41
 */

namespace App\Models;


class CompanyModel extends BaseModel
{
    protected $table = "company";
    protected $primaryKey = 'company_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    public function companyUser(){
        return $this->hasMany("App\Models\CompanyUserModel","company_id","company_id");
    }
}