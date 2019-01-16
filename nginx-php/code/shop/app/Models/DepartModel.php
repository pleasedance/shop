<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 13:29
 */

namespace App\Models;


class DepartModel extends BaseModel
{
    protected $table = "company_depart";
    protected $primaryKey = 'depart_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除
}