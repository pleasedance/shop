<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/8
 * Time: 17:23
 */

namespace App\Models;


class CompanyMoneyLogModel extends BaseModel
{
    protected $table = "company_money_log";
    
    //禁止update_at
    const UPDATED_AT = NULL;
}