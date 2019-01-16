<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:22
 */

use Illuminate\Http\Request;

Route::prefix('system')->namespace("System")->group(function(){
    Route::post('/', 'MainController@postIndex');       //登陆
    Route::delete('/', 'MainController@deleteIndex');       //退出登录
    Route::get('/', 'MainController@getIndex');       //登陆界面

    Route::prefix('admin')->namespace("Admin")->group(function (){
        Route::get('/', 'MainController@getIndex');       //管理员列表
        Route::get('user/{id?}', 'MainController@getUser');       //管理员详情
        Route::post('user', 'MainController@postUser');       //管理员添加
        Route::put('user/{id?}', 'MainController@putUser');       //管理员修改
        Route::put('userstat', 'MainController@putUserStat');       //管理员禁用与启用

        Route::get('sellerlist', 'MainController@getSellerList');       //商家列表
        Route::put('sellerstat', 'MainController@putSellerStat');       //商家禁用与启用
        Route::get('seller/{id?}', 'MainController@getSeller');       //商家详情
        Route::post('seller', 'MainController@postSeller');       //商家添加
        Route::put('seller/{id?}', 'MainController@putSeller');       //商家修改

        Route::get('rolelist', 'MainController@getRoleList');       //角色列表
        Route::get('role/{id?}', 'MainController@getRole');       //角色详情
        Route::post('role', 'MainController@postRole');       //角色添加
        Route::put('role/{id?}', 'MainController@putRole');       //角色修改
//        Route::get('/', 'MainController@getIndex');       //首页

        Route::post('category', 'CategoryController@postCategory');       //分类添加
        Route::get('category/{id?}', 'CategoryController@getCategory');       //分类详情页面
        Route::put('category/{id?}', 'CategoryController@putCategory');       //分类修改
        Route::get('catalog', 'CategoryController@getCatalog');       //分类列表页面
        Route::put('categorystat', 'CategoryController@putCategoryStat');       //分类禁用与启用
        Route::put('categorydel', 'CategoryController@putCategoryDel');       //分类删除

        Route::post('categoryparam/{cid?}', 'CategoryController@postCategoryParam');       //分类参数组添加
        Route::get('categoryparam/{cid?}/{paramNumber?}', 'CategoryController@getCategoryParam');       //分类参数组详情页面
        Route::put('categoryparam/{cid?}/{paramNumber?}', 'CategoryController@putCategoryParam');       //分类参数组修改
        Route::get('cateparamlog/{cid?}', 'CategoryController@getCateParamLog');       //分类参数组列表页面
        Route::put('cateparamstat', 'CategoryController@putCategoryParamStat');       //分类参数禁用与启用
        Route::put('cateparamdel', 'CategoryController@putCategoryParamDel');       //分类参数删除

        Route::post('categoryparampro/{paramNumber?}', 'CategoryController@postCategoryParamPro');       //分类参数属性添加
        Route::get('categoryparampro/{paramNumber?}/{id?}', 'CategoryController@getCategoryParamPro');       //分类参数属性详情页面
        Route::put('categoryparampro/{paramNumber?}/{id?}', 'CategoryController@putCategoryParamPro');       //分类参数属性修改
        Route::get('cateparamprolog/{cid?}', 'CategoryController@getCateParamLogPro');       //分类参数属性列表页面

        Route::post('categorysku/{cid?}', 'CategoryController@postCategorySku');       //分类sku添加
        Route::get('categorysku/{cid?}/{skuNumber?}', 'CategoryController@getCategorySku');       //分类sku详情页面
        Route::put('categorysku/{cid?}/{skuNumber?}', 'CategoryController@putCategorySku');       //分类sku修改
        Route::get('categoryskulog/{cid?}', 'CategoryController@getCategorySkuLog');       //分类sku列表页面
        Route::put('cateskustat', 'CategoryController@putCategorySkuStat');       //分类Sku禁用与启用
        Route::put('cateskudel', 'CategoryController@putCategorySkuDel');       //分类Sku删除

        Route::post('categoryskuproperties/{skuNumber?}', 'CategoryController@postCategorySkuProperties');       //分类sku值添加
        Route::get('categoryskuproperties/{cid?}/{id?}', 'CategoryController@getCategorySkuProperties');       //分类sku值详情页面
        Route::put('categoryskuproperties/{skuNumber?}/{id?}', 'CategoryController@putCategorySkuProperties');       //分类sku值修改
        Route::get('categoryskupropertieslog/{skuNumber?}', 'CategoryController@getCategorySkuPropertiesLog');       //分类sku值列表页面

        Route::post('brand', 'BrandController@postBrand');       //品牌添加
        Route::get('brand/{id?}', 'BrandController@getBrand');       //品牌详情页面
        Route::put('brand/{id?}', 'BrandController@putBrand');       //品牌修改
        Route::get('brandlog', 'BrandController@getBrandLog');       //品牌列表页面
        Route::put('brandstat', 'BrandController@putBrandStat');       //品牌展示与不展示
        Route::put('branddel', 'BrandController@putBrandDel');       //品牌删除

        Route::get('advertisements', 'BrandController@getAdvertisements');       //广告列表
        Route::get('advertisement/{id?}', 'BrandController@getAdvertisement');       //广告详情
        Route::post('advertisement', 'BrandController@postAdvertisement');       //广告添加
        Route::put('advertisement/{id?}', 'BrandController@putAdvertisement');       //广告修改
        Route::put('advertisementdel', 'BrandController@putAdvertisementDel');       //广告删除

        Route::get('amountlog', 'MainController@getAmountLog');       //发放给企业明细
        Route::get('amount/user/log', 'MainController@getAmountUserLog');       //用户充值明细
    });
});