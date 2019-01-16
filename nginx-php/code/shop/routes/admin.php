<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//会话
Route::prefix('passport')->namespace("Passport")->group(function(){
    Route::post('sms', 'MainController@postSms');       //发短信
    Route::post('/', 'MainController@postIndex');       //登陆
    Route::delete('/', 'MainController@deleteIndex');       //退出登录
    Route::get('/', 'MainController@getIndex');       //登陆界面
});

Route::prefix('company')->namespace("Company")->group(function(){
    Route::post('status', 'MainController@postStatus');       //启用
    Route::delete('status', 'MainController@deleteStatus');       //禁用
    Route::get('form', 'MainController@getForm');       //表单
    Route::post('assign', 'MainController@postAssign');       //流量分配
    Route::get('assign', 'MainController@getAssign');       //流量分配记录
    Route::get('sms', 'MainController@getSms');       //短信发送记录
    
    Route::prefix('statement')->namespace("Statement")->group(function(){
        Route::get('sms', 'SmsController@getIndex');       //短信明细
        Route::get('sms/form', 'SmsController@getForm');       //添加短信表单
        Route::post('sms', 'SmsController@postIndex');       //短信
        Route::get('user', 'UserController@getIndex');       //流量明细
        Route::get('money', 'MoneyController@getIndex');       //余额明细
    });
    
    Route::get('/', 'MainController@getIndex');       //列表
    Route::post('/', 'MainController@postIndex');       //保存
});

Route::prefix('order')->namespace("Order")->group(function(){
    
    Route::post('user/status', 'UserController@postStatus');       //通过
    Route::delete('user/status', 'UserController@deleteStatus');       //拒绝
    Route::get('user', 'UserController@getIndex');       //列表
    
    Route::post('sms/status', 'SmsController@postStatus');       //通过
    Route::delete('sms/status', 'SmsController@deleteStatus');       //拒绝
    Route::get('sms', 'SmsController@getIndex');       //列表
    
    Route::post('money/status', 'MoneyController@postStatus');       //通过
    Route::delete('money/status', 'MoneyController@deleteStatus');       //拒绝
    Route::get('money', 'MoneyController@getIndex');       //列表
});

Route::prefix('system')->namespace("System")->group(function(){
    Route::post('admin/status', 'AdminController@postStatus');       //管理员启用
    Route::delete('admin/status', 'AdminController@deleteStatus');       //管理员禁用
    Route::get('admin/form', 'AdminController@getForm');       //表单
    Route::get('admin', 'AdminController@getIndex');       //列表
    Route::post('admin', 'AdminController@postIndex');       //保存
    
    
    Route::post('role/status', 'RoleController@postStatus');       //角色启用
    Route::delete('role/status', 'RoleController@deleteStatus');       //角色禁用
    Route::get('role/form', 'RoleController@getForm');       //表单
    Route::get('role', 'RoleController@getIndex');       //列表
    Route::post('role', 'RoleController@postIndex');       //保存
    
    Route::post('companypay/status', 'CompanypayController@postStatus');       //配置启用
    Route::delete('companypay/status', 'CompanypayController@deleteStatus');       //配置禁用
    Route::get('companypay/form', 'CompanypayController@getForm');       //表单
    Route::get('companypay', 'CompanypayController@getIndex');       //列表
    Route::post('companypay', 'CompanypayController@postIndex');       //保存
    
});

Route::prefix('user')->namespace("User")->group(function(){
    Route::post('import', 'MainController@postImport');       //导入
    Route::get('/', 'MainController@getIndex');       //列表
    Route::post('/', 'MainController@postIndex');       //添加
});


Route::prefix('public')->group(function(){
    Route::post('image', 'PublicController@postImage');       //上传图片
});


Route::prefix('import')->group(function(){
    Route::get('download', 'ImportController@getDownload');
    Route::get('/', 'ImportController@getIndex');
});

//Route::get('profile', 'MainController@getProfile');
//Route::post('profile', 'MainController@postProfile');
//Route::get('/', 'MainController@getIndex');