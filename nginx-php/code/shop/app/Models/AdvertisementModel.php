<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9
 * Time: 19:32
 */

namespace App\Models;


class AdvertisementModel extends BaseModel
{
    protected $table = "advertisement";
    protected $primaryKey = 'ad_id';

    const xiaochengxu = 0;//小程序首页轮播
    const notxiaochengxu = 1;//小程序外

    const start = 1;//上线
    const nostart = 0;//下线

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    //禁止update_at
    const UPDATED_AT = NULL;
}