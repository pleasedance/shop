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
//        "href" => "/",
//    ],
    [
        "permission" => FALSE,
        "name" => "系统管理",
        "icon" => "icon-settings",
        "items" => [
            [
                "code" => "admin",
                "name" => "管理员管理",
                "href" => "/system/admin",
            ],
            [
                "code" => "role",
                "name" => "角色管理",
                "href" => "/system/admin/rolelist",
            ],
            [
                "code" => "seller",
                "name" => "商家列表",
                "href" => "/system/admin/sellerlist",
            ],
            [
                "code" => "advertisement",
                "name" => "广告设置",
                "href" => "/system/admin/advertisements",
            ],
        ],
    ],
    [
        "permission" => PermissionHelper::seller,
        "code" => "faretemplate",
        "name" => "商家管理",
        "icon" => "icon-user",
        "items" => [
            [
                "permission" => false,
                "code" => "category",
                "name" => "商品分类",
                "items" => [
                    [
                        "code" => "category",
                        "name" => "商品分类列表",
                        "href" => "/system/admin/catalog",
                    ],
                ]
            ],
            [
                "code" => "brand",
                "name" => "品牌管理",
                "href" => "/system/admin/brandlog",
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
                "name" => "发放给企业明细",
                "href" => "/system/admin/amountlog",
            ],
            [
                "code" => "amount/user/log",
                "name" => "用户充值明细",
                "href" => "/system/admin/amount/user/log",
            ],
        ],
    ],
];
