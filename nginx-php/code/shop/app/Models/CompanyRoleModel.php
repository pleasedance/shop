<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 13:39
 */

namespace App\Models;


class CompanyRoleModel extends BaseModel
{
    protected $table = "company_role";
    protected $primaryKey = 'role_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}