<?php

use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 10:18
 */

Route::prefix('seller')->namespace("Seller")->group(function(){
//    Route::post('sms', 'MainController@postSms');       //发短信
    Route::post('register', 'MainController@postRegister');       //商户注册
    Route::get('register', 'MainController@getRegister');       //商户注册页面
    Route::post('register/user', 'MainController@getRegisterUser');       //商户管理员注册
    Route::get('register/user', 'MainController@getRegisterUser');       //商户管理员注册页面
    Route::post('/', 'MainController@postIndex');       //登陆
    Route::delete('/', 'MainController@deleteIndex');       //退出登录
    Route::get('/', 'MainController@getIndex');       //登陆界面
});

Route::prefix('selleradmin')->namespace("Seller\SellerAdmin")->group(function(){
//    Route::get('adminlist', 'MainController@getAdminList');       //商家管理员列表
//    Route::get('sellerlist', 'MainController@getSellerList');       //商家列表
//    Route::put('seller', 'MainController@putSeller');       //商家禁用与启用
//    Route::get('rolelist', 'MainController@getRoleList');       //角色列表
//    Route::get('role/{id?}', 'MainController@getRole');       //角色详情
//    Route::post('role', 'MainController@postRole');       //角色添加
//    Route::put('role/{id?}', 'MainController@putRole');       //角色修改

    Route::post('address', 'MainController@postAddress');       //商户添加收货地址
    Route::post('setAddress', 'MainController@setAddress');       //商户设置默认地址
    Route::get('address/{id?}', 'MainController@getAddress');       //商户收货地址详情页面
    Route::put('address/{id?}', 'MainController@putAddress');       //商户修改收货地址
    Route::get('addresslist', 'MainController@getAddressList');       //商户地址列表页面
    Route::get('/', 'MainController@getIndex');       //商户后台首页
    Route::post('sellerconfig', 'SellerConfigController@postSellerConfig');       //商户添加配置
    Route::get('sellerconfig/{id?}', 'SellerConfigController@getSellerConfig');       //商户配置详情页面
    Route::put('sellerconfig/{id?}', 'SellerConfigController@putSellerConfig');       //商户修改配置
    Route::post('delSellerConfig', 'SellerConfigController@delSellerConfig');       //商户删除配置
    Route::get('sellerconfiglist', 'SellerConfigController@getSellerConfigList');       //商户配置列表页面

    Route::post('faretemplate', 'FareTemplateController@postFareTemplate');       //商户运费模板添加
    Route::get('faretemplate/{id?}', 'FareTemplateController@getFareTemplate');       //商户运费模板详情
    Route::put('faretemplate/{id?}', 'FareTemplateController@putFareTemplate');       //商户运费模板修改
    Route::get('faretemplatelist', 'FareTemplateController@getFareTemplateList');       //商户运费模板列表
    Route::post('carrymode', 'FareTemplateController@postCarryMode');       //商户运费模板运送方式选择
    Route::put('faretmpstat', 'FareTemplateController@putFaretmpstat');       //运费模板禁用与启用
    Route::put('deltmp', 'FareTemplateController@putDeltmp');       //运费模板禁用与启用

//    Route::post('category', 'CategoryController@postCategory');       //分类添加
//    Route::get('category/{id?}', 'CategoryController@getCategory');       //分类详情页面
//    Route::put('category/{id?}', 'CategoryController@putCategory');       //分类修改
//    Route::get('catalog', 'CategoryController@getCatalog');       //分类列表页面
//    Route::put('categorystat', 'CategoryController@putCategoryStat');       //分类禁用与启用
//    Route::put('categorydel', 'CategoryController@putCategoryDel');       //分类删除
//
//    Route::post('categoryparam/{cid?}', 'CategoryController@postCategoryParam');       //分类参数组添加
//    Route::get('categoryparam/{cid?}/{paramNumber?}', 'CategoryController@getCategoryParam');       //分类参数组详情页面
//    Route::put('categoryparam/{cid?}/{paramNumber?}', 'CategoryController@putCategoryParam');       //分类参数组修改
//    Route::get('cateparamlog/{cid?}', 'CategoryController@getCateParamLog');       //分类参数组列表页面
//    Route::put('cateparamstat', 'CategoryController@putCategoryParamStat');       //分类参数禁用与启用
//    Route::put('cateparamdel', 'CategoryController@putCategoryParamDel');       //分类参数删除
//
//    Route::post('categoryparampro/{cid?}', 'CategoryController@postCategoryParamPro');       //分类参数属性添加
//    Route::get('categoryparampro/{cid?}/{id?}', 'CategoryController@getCategoryParamPro');       //分类参数属性详情页面
//    Route::put('categoryparampro/{cid?}/{id?}', 'CategoryController@putCategoryParamPro');       //分类参数属性修改
//    Route::get('cateparamprolog/{cid?}', 'CategoryController@getCateParamLogPro');       //分类参数属性列表页面
//
//    Route::post('categorysku/{cid?}', 'CategoryController@postCategorySku');       //分类sku添加
//    Route::get('categorysku/{cid?}/{skuNumber?}', 'CategoryController@getCategorySku');       //分类sku详情页面
//    Route::put('categorysku/{cid?}/{skuNumber?}', 'CategoryController@putCategorySku');       //分类sku修改
//    Route::get('categoryskulog/{cid?}', 'CategoryController@getCategorySkuLog');       //分类sku列表页面
//    Route::put('cateskustat', 'CategoryController@putCategorySkuStat');       //分类Sku禁用与启用
//    Route::put('cateskudel', 'CategoryController@putCategorySkuDel');       //分类Sku删除
//
//    Route::post('categoryskuproperties/{skuNumber?}', 'CategoryController@postCategorySkuProperties');       //分类sku值添加
//    Route::get('categoryskuproperties/{cid?}/{id?}', 'CategoryController@getCategorySkuProperties');       //分类sku值详情页面
//    Route::put('categoryskuproperties/{skuNumber?}/{id?}', 'CategoryController@putCategorySkuProperties');       //分类sku值修改
//    Route::get('categoryskupropertieslog/{skuNumber?}', 'CategoryController@getCategorySkuPropertiesLog');       //分类sku值列表页面

    Route::get('catalog/product', 'ProductController@getCatalogProduct');       //选择分类
    Route::post('product/{id?}', 'ProductController@postProduct');       //商品添加
    Route::get('product/{id?}/{productNumber?}', 'ProductController@getProduct');       //商品详情页面
    Route::put('product/{id?}/{productNumber?}', 'ProductController@putProduct');       //商品修改
    Route::get('productlog', 'ProductController@getProductLog');       //商品列表页面
    Route::post('del/product', 'ProductController@delProduct');       //删除商品

    Route::get('productparams/{productNumber?}', 'ProductController@getCateParamLog');       //商品参数组列表
    Route::get('productparam/{productNumber?}/{paramNumber?}', 'ProductController@getCategoryParam');       //商品参数组详情
    Route::post('productparam/{productNumber?}', 'ProductController@postCategoryParam');       //商品参数组添加
    Route::put('productparam/{productNumber?}/{paramNumber?}', 'ProductController@putCategoryParam');       //商品参数组修改

    Route::post('productparampro/{paramNumber?}', 'ProductController@postCategoryParamPro');       //商品参数属性添加
    Route::get('productparampro/{paramNumber?}/{id?}', 'ProductController@getCategoryParamPro');       //商品参数属性详情页面
    Route::put('productparampro/{paramNumber?}/{id?}', 'ProductController@putCategoryParamPro');       //商品参数属性修改
    Route::get('productparampros/{cid?}', 'ProductController@getCateParamLogPro');       //商品参数属性列表页面

    Route::get('order', 'OrderController@getOrder');       //订单列表
    Route::get('order/{orderSn?}', 'OrderController@getOrderDetail');       //订单详情页面
    Route::put('order/cancel/{id?}', 'OrderController@putOrderCancel');       //订单取消
    Route::put('order/send/{orderSn?}', 'OrderController@putOrderSend');       //订单发货
    Route::put('order/changeaddr/{orderSn?}', 'OrderController@putOrderChangeAddr');       //订单发货地址修改
    Route::put('order/changemoney/{orderSn?}', 'OrderController@putOrderChangeMoney');       //订单改价
    Route::put('order/receipt/{orderSn?}', 'OrderController@putOrderReceipt');       //订单收货
    Route::get('returns', 'OrderController@getOrderReturns');       //退货列表

    Route::put('order/agree/{orderSubSn?}', 'OrderController@putOrderAgree');       //同意申请
    Route::put('order/refuse/{orderSubSn?}', 'OrderController@putOrderRefuse');       //拒绝申请
    Route::put('order/confirm/{orderSubSn?}', 'OrderController@putOrderConfirm');       //确认退货
    Route::put('order/refund/{orderSubSn?}', 'OrderController@putOrderRefund');       //退款

//    Route::post('brand', 'ProductController@postBrand');       //品牌添加
//    Route::get('brand/{id?}', 'ProductController@getBrand');       //品牌详情页面
//    Route::put('brand/{id?}', 'ProductController@putBrand');       //品牌修改
//    Route::get('brandlog', 'ProductController@getBrandLog');       //品牌列表页面
//    Route::put('brandstat', 'ProductController@putBrandStat');       //品牌展示与不展示
//    Route::put('branddel', 'ProductController@putBrandDel');       //品牌删除
});
//Route::get('/', 'MainController@getIndex');

Route::prefix('public')->group(function(){
    Route::post('image', 'PublicController@postImage');       //上传图片
    Route::post('images', 'PublicController@postImages');       //上传多个图片
    Route::post('api/images', 'PublicController@postApiImages');       //上传多个图片
});
