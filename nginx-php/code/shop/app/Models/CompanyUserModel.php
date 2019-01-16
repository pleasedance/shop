<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 18:44
 */

namespace App\Models;


class CompanyUserModel extends BaseModel
{
    protected $table = "company_user";
    protected $primaryKey = 'sys_user_id';

    const roleRoot = 'root';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    public function company(){
        return $this->belongsTo("App\Models\CompanyModel","company_id","company_id");
    }
}