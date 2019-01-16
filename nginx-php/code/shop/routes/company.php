<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/4
 * Time: 18:12
 */

Route::prefix('company')->namespace("Company")->group(function(){
    Route::post('/', 'MainController@postIndex');       //登陆
    Route::get('/', 'MainController@getIndex');       //登陆页
    Route::delete('/', 'MainController@deleteIndex');       //退出登录
});

Route::prefix('companyadmin')->namespace("Company\CompanyAdmin")->group(function(){
    Route::get('/', 'MainController@getIndex');       //企业列表
    Route::get('add/{id?}', 'MainController@getAdd');       //企业添加页
    Route::post('add', 'MainController@postAdd');       //企业添加
    Route::put('add/{id?}', 'MainController@putAdd');       //企业修改
    Route::get('users', 'MainController@getUsers');       //企业管理员列表
    Route::get('user/{id?}', 'MainController@getUser');       //企业管理员详情
    Route::post('user', 'MainController@postUser');       //添加企业管理员
    Route::put('user/{id?}', 'MainController@putUser');       //修改企业管理员

    Route::get('role/{id?}', 'MainController@getRole');       //角色详情
    Route::post('role', 'MainController@postRole');       //添加角色
    Route::put('role/{id?}', 'MainController@putRole');       //修改角色
    Route::get('rolelist', 'MainController@getRoleList');       //角色列表

    Route::get('buyer/{id?}', 'MainController@getBuyer');       //会员详情
    Route::post('buyer', 'MainController@postBuyer');       //添加会员
    Route::put('buyer/{id?}', 'MainController@putBuyer');       //修改会员
    Route::get('buyers', 'MainController@getBuyers');       //会员列表
    Route::put('buyerstat', 'MainController@putBuyerStat');       //会员禁用与启用

    Route::get('depart/{id?}', 'MainController@getDepart');       //部门详情
    Route::post('depart', 'MainController@postDepart');       //添加部门
    Route::put('depart/{id?}', 'MainController@putDepart');       //修改部门
    Route::get('departs', 'MainController@getDeparts');       //部门列表
    Route::put('departstat', 'MainController@putDepartStat');       //部门禁用与启用
    Route::put('departdel', 'MainController@putDepartDel');       //部门删除

    Route::post('buyerrecharge', 'MainController@postBuyerRecharge');       //员工充值
    Route::post('companyrecharge', 'MainController@postCompanyRecharge');       //企业充值
    Route::get('amountlog', 'MainController@getAmountLog');       //企业充值明细
    Route::get('amount/user/log', 'MainController@getAmountUserLog');       //企业发放明细

    Route::get('registered', 'MainController@getRegistered');       //二维码注册

});