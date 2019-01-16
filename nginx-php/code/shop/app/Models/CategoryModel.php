<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/8
 * Time: 13:23
 */

namespace App\Models;


class CategoryModel extends BaseModel
{
    protected $table = "pd_category";
    protected $primaryKey = 'category_id';

    const statusActive = 1;//启用
    const statusInactive = 0;//未启用

    const delActive = 1;//删除
    const delInactive = 0;//未删除

    const showNavigation = 1;//导航栏显示
    const noshowNavigation = 0;//导航栏不显示
}