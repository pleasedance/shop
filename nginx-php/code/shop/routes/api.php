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


Route::prefix('company')->group(function(){
    Route::get('detail', 'CompanyController@getDetail');        //商户详情
    Route::get('order', 'CompanyController@getOrder');          //获取订单列表
    Route::post('order', 'CompanyController@postOrder');        //添加订单
    Route::get('paytype', 'CompanyController@getPaytype');        //获取支付类型
    Route::post('moneyStatement', 'CompanyController@postMoneyStatement');        //商户扣资金
    Route::post('/', 'CompanyController@postIndex');        //保存商户信息
});


Route::prefix('statement')->group(function(){
    Route::get('sms', 'StatementController@getSms');        //短信明细
    Route::get('user', 'StatementController@getUser');          //流量明细
    Route::get('money', 'StatementController@getMoney');        //余额明细
});

Route::prefix('user')->group(function(){
    Route::get('info', 'UserController@getInfo');
    Route::get('taobaoOrder', 'UserController@getTaobaoOrder');
    Route::get('taobaoAddress', 'UserController@getTaobaoAddress');
    Route::get('callRecord', 'UserController@getCallRecord');
    Route::get('mobileBook', 'UserController@getMobileBook');
    
    Route::post('/', 'UserController@postIndex');       //保存用户信息
});

Route::post('phone', 'PhoneController@postIndex');                  //发短信

//------------------------------------------------------
Route::get('category', 'DefaultController@getCategory');        //分类展示
Route::get('product', 'DefaultController@getProduct');        //商品展示
Route::get('product/detail/{productNumber?}', 'DefaultController@getProductDetail');        //商品详情
Route::post('login', 'DefaultController@postLogin');        //员工登陆
Route::get('personal', 'UserController@getPersonal');        //用户信息
Route::get('user/head/{buyerId?}', 'DefaultController@getUserHead');        //用户姓名与头像
Route::get('user/invite/{buyerId?}', 'DefaultController@getInviteUser');        //邀请人列表
Route::get('money/detail', 'UserController@getMoneyDetail');        //栗子
Route::post('supplement/user', 'UserController@postSupplementUserInfo');        //补充用户信息
Route::get('company/info', 'DefaultController@getCompanyInfo');        //企业信息
Route::post('recharge', 'UserController@postRecharge');        //充值
Route::get('recharge/log', 'UserController@getRechargeLog');        //充值记录
Route::post('address', 'UserController@postAddress');        //添加收货信息
Route::put('address/{id?}', 'UserController@putAddress');        //修改收货信息
Route::delete('address/{id?}', 'UserController@deleteAddress');        //删除收货信息
Route::get('address/list', 'UserController@getAddressList');        //收货信息列表

Route::post('evaluation', 'UserController@postEvaluation');        //评价
Route::get('evaluations', 'DefaultController@getEvaluations');        //评价列表

Route::get('cart', 'UserController@getCart');        //购物车列表
Route::post('cart', 'UserController@postCart');        //添加商品到购物车
Route::delete('cart', 'UserController@deleteCart');       //从购物车删除商品

Route::post('order', 'OrderController@postOrder');        //下单
Route::post('cancel', 'OrderController@postCancel');        //取消订单
Route::post('pay', 'OrderController@postPay');        //支付
Route::post('paycallback/{buyerId?}/{flag?}', 'DefaultController@postPayCallback');        //微信支付回调
Route::post('rechargecallback/{buyerId?}', 'DefaultController@postRechargeCallback');        //微信充值回调
Route::post('payrefundcallback/{buyerId?}', 'DefaultController@postPayRefundCallback');        //微信退款回调
Route::post('payreturngoodscallback/{buyerId?}', 'DefaultController@postPayReturnGoodsCallback');        //微信退货退款回调
Route::post('order/return', 'OrderController@postReturn');        //退款申请
Route::post('order/info', 'OrderController@postOrderInfo');        //订单信息
Route::get('orders', 'OrderController@getOrders');        //订单列表
Route::get('order/detail', 'OrderController@getOrderDetail');        //订单详情
Route::post('order/receipt', 'OrderController@postOrderReceipt');        //订单收货
Route::post('del/order', 'OrderController@postOrderDel');        //订单删除
Route::get('returns', 'OrderController@getReturns');        //退货单列表
Route::get('return/goods/{orderSubSn?}','OrderController@getReturnGoods');        //退货单详情
Route::get('return/set/shipping_sn','OrderController@postSetShippingSn');        //设置退货单快递

Route::post('seedTemp', 'DefaultController@postSeedTemp');        //发送模板消息
Route::get('advertisements', 'DefaultController@getAdvertisements');        //广告列表




