<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:30
 */

namespace App\Models;


class SystemUserModel extends BaseModel
{
    protected $table = "system_user";

    const roleRoot = 'root';

    const statusActive = 1;//启用
    const statusInactive = 0;//不启用
}