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
        //"permission" => PermissionHelper::seller,
        "code" => "faretemplate",
        "name" => "商家管理",
        "icon" => "icon-user",
        "items" => [
            [
                "code" => "faretemplate",
                "name" => "运费模板",
                "href" => "/selleradmin/faretemplatelist",
            ],
            [
                "code" => "product",
                "name" => "商品管理",
                "href" => "/selleradmin/productlog",
            ],
        ],
    ],
    [
        //"permission" => PermissionHelper::seller,
        "name" => "商家订单",
        "icon" => "fa fa-cc",
        "items" => [
            [
                "code" => "order",
                "name" => "订单管理",
                "href" => "/selleradmin/order",
            ],
            [
                "code" => "order/returns",
                "name" => "退货订单",
                "href" => "/selleradmin/returns",
            ],
        ],
    ],
    [
        "code" => "parametersetting",
        "icon" => "fa fa-cloud-download",
        "name" => "参数设置",
        "items" => [
            [
                "code" => "addresslist",
                "name" => "商家收货地址",
                "href" => "/selleradmin/addresslist",
            ],
            [
                "code" => "sellerconfig",
                "name" => "商家配置",
                "href" => "/selleradmin/sellerconfiglist",
            ],
        ]
    ],
];
