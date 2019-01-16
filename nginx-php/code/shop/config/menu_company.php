<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
//    [
//        "code" => "index",
//        "name" => "首页",
//        "icon" => "icon-home",
//        "href" => "/companyadmin",
//    ],
    [
        "permission" => FALSE,
        "name" => "系统管理",
        "icon" => "icon-settings",
        "items" => [
            [
                "code" => "role",
                "name" => "角色管理",
                "href" => "/companyadmin/rolelist",
            ],
            [
                "code" => "buyers",
                "name" => "企业管理",
                "href" => "/companyadmin",
            ],
        ],
    ],
    [
//        "permission" => CompanyPermissionHelper::user,
        "name" => "用户管理",
        "icon" => "icon-users",
        "items" => [
            [
                "code" => "registered",
                "name" => "二维码注册",
                "href" => "/companyadmin/registered",
            ],
            [
                "code" => "buyers",
                "name" => "员工管理",
                "href" => "/companyadmin/buyers",
            ],
            [
                "code" => "departs",
                "name" => "部门管理",
                "href" => "/companyadmin/departs",
            ],
            [
                "code" => "users",
                "name" => "账号管理",
                "href" => "/companyadmin/users",
            ],
        ],
    ],
    [
        "code" => "amountlog",
        "name" => "代币记录",
        "icon" => "icon-home",
        "items" => [
            [
                "code" => "amountlog",
                "name" => "企业充值明细",
                "href" => "/companyadmin/amountlog",
            ],
            [
                "code" => "amount/user/log",
                "name" => "企业发放明细",
                "href" => "/companyadmin/amount/user/log",
            ],
        ],
    ],
];
