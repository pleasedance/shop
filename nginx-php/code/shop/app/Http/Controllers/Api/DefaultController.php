<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 11:25
 */

namespace App\Http\Controllers\Api;

use App\Models\BuyerModel;

class DefaultController extends \App\Http\Controllers\Controller
{

    /**
     * @return mixed
     * 评价列表
     */
    public function getEvaluations()
    {
        $request = \Request::all();
        $query = \App\Models\EvaluationModel::where("product_number",$request["product_number"])
            ->with("reply")
            ->with("buyer")
            ->with("sku");
        $total = $query->count();
        $goodTotal = $query->where("des_match",">",\App\Models\EvaluationModel::general)->count();
        $goodRatio = "";
        if ($total){
            $goodRatio = round($goodTotal/$total*100,2)."%";
        }
        $query->offset(($request['offset']-1)*$request['limit'])
            ->limit($request['limit']);
        $result = $query->get();
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
            "good_ratio"=>$goodRatio,
        ]);
    }

    /**
     * @return mixed
     * 用户姓名与头像
     */
    public function getUserHead($buyerId = 0)
    {
        $model = \App\Models\BuyerModel::where("buyer_id", $buyerId)->first();
        if (!$model) {
            return \ResponseHelper::error("用户不存在", NULL, NULL, 500);
        }
        return \ResponseHelper::success([
            "real_name" => $model->real_name,
            "head_img" => $model->head_img,
        ]);
    }

    /**
     * @return mixed
     * 邀请人列表
     */
    public function getInviteUser($buyerId = 0)
    {
        $list = \App\Models\BuyerModel::where("invite_user", $buyerId)->get();
        return \ResponseHelper::success([
            "list" => $list,
        ]);
    }

    /**
     * @return mixed
     * 广告列表
     */
    public function getAdvertisements()
    {
        $request = \Request::all();
        $list = \App\Models\AdvertisementModel::where("del_status",\App\Models\AdvertisementModel::delInactive)
            ->where("start_status",\App\Models\AdvertisementModel::start)
            ->where("ad_position",$request["position"])
            ->take($request["take"])
            ->get();
        return \ResponseHelper::success([
            "list" => $list,
        ]);
    }

    /**
     * @return mixed
     * 分类展示
     */
    public function getCategory()
    {
        $query= \App\Models\CategoryModel::where("del_status",\App\Models\CategoryModel::delInactive)
            ->where("status",\App\Models\CategoryModel::statusActive)
//            ->orderBy("sort","asc")
            ->orderBy("sort","asc");
        $total=$query->count();
        $result=$query->get();
//        $result=$query->simplePaginate(20);
        $list=[];
        if($result->toArray()){
            foreach ($result as $value) {
                $list[]=[
                    "id"=>$value->category_id,
                    "parent_id"=>$value->parent_id,
                    "name"=>$value->name,
                    "level"=>$value->level,
                    "sort"=>$value->sort,
                    "picture_url"=>$value->picture_url,
                    "navigation_status"=>$value->navigation_status,
                    "created_at"=>$value->created_at,
                    "updated_at"=>$value->updated_at,
                ];
            }
        }
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$list,
        ]);
    }

    /**
     * @return mixed
     * 商品列表
     */
    public function getProduct()
    {
        $request = \Request::all();
        $query = \App\Models\ProductModel::where("del_status",\App\Models\ProductModel::delInactive);
        $query = $query->where("pd_is_sell",\App\Models\ProductModel::isSell);
//        if (!empty($request["name"])){
//            $query = $query->where("pd_name","like","%".$request["name"]."%");
//        }
        if (!empty($request["category_id"])){
            $query = $query->where("pd_category_id",$request["category_id"]);
        }
        if (!empty($request["brand_id"])){
            $query = $query->where("pd_brand_id",$request["brand_id"]);
        }
        if (!empty($request["key_word"])){
            $query = $query->where("pd_key_word","like","%".$request["key_word"]."%");
        }
        if (!empty($request["recommend_type"])){
            $query = $query->where("pd_recommend_type",$request["recommend_type"]);
        }
        if (isset($request["sales_ob"])){
            //销量
            if ($request["sales_ob"]>0){
                $query = $query->orderBy('sales_num','asc');
            }else{
                $query = $query->orderBy('sales_num','desc');
            }
        }
        if (isset($request["mp_ob"])){
            //市场价
            if ($request["mp_ob"]>0){
                $query = $query->orderBy('min_price','asc');
            }else{
                $query = $query->orderBy('min_price','desc');
            }
        }

//        $query = $query->orderBy('created_at','desc');
//        $query = $query->orderBy('product_id','desc');
        $query = $query->orderBy('pd_sort','asc');

        $query->with("sku");
        $query->with("skuProperties");
        $total=$query->count();
        $query->offset(($request['offset']-1)*$request['limit']);
        $query->limit($request['limit']);
        $result=$query->get();
        $list=[];
        if($result->toArray()){
            foreach ($result as $value) {
                /*
                 * //取最小值
                 * \Log::info($value->skuProperties);
                $min = 10000000000000;
                if (isset($value->skuProperties)){
                    foreach ($value->skuProperties as $v){
                        if ($v->pd_price < $min){
                            $min = $v->pd_price;
                        }
                    }
                }*/

                $list[]=[
                    "id"=>$value->product_id,
                    "product_art_no"=>$value->product_art_no,
                    "product_number"=>$value->product_number,
                    "pd_name"=>$value->pd_name,
                    "pd_subtitle"=>$value->pd_subtitle,
                    "category_id"=>$value->pd_category_id,
                    "seller_id"=>$value->pd_seller_id,
                    "brand_id"=>$value->pd_brand_id,
                    "image_url"=>$value->pd_image_url,
                    "translation_url"=>$value->pd_translation_pic,
                    "market_price"=>$value->market_price,
                    "express_tpl_id"=>$value->express_tpl_id,
                    "sku"=>$value->sku,
                    "sku_properties"=>$value->skuProperties,
                    "min_price"=>$value->min_price,
                ];
            }
        }
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$list,
        ]);
    }

    /**
     * @param string $productNumber
     * @return mixed
     * 商品详情
     */
    public function getProductDetail($productNumber="")
    {
        $model = \App\Models\ProductModel::where("product_number",$productNumber)
            ->with("sku")
            ->with("skuProperties")
            ->first();
        return \ResponseHelper::success([
            "ret"=>$model,
        ]);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 小程序员工登陆
     */
    public function postLogin()
    {
        $request = \Request::all();
        \Log::info("登陆请求数据-----------");
        \Log::info($request);
        \DB::beginTransaction();
        if ($request['code']){
            $curl = new \JSocket();
            $curl->setRetFormat(\JSocket::retFormatJson);
            $curl->setUrl(config("company.login"));
            $curl->setParam("appid",config("company.appid"));
            $curl->setParam("secret",config("company.appsecret"));
            $curl->setParam("js_code",$request["code"]);
            $curl->setParam("grant_type","authorization_code");
            $curl->setTimeout(30);
            $curl->setMethod(\JSocket::methodGet);
            $curl->exe();
            $r = $curl->getRet();
            $userinfo = json_decode($request['userinfo'],TRUE);
//            \Log::info($userinfo);
            \Log::info($userinfo['userInfo']);
//            return;

            $buyerModel = \App\Models\BuyerModel::where("wechat_openid",$r['openid'])->first();
            $msg = "";
            if(!$buyerModel || $buyerModel->status != \App\Models\BuyerModel::statusActive){
//                if(empty($request["company_id"])){
//                    return \ResponseHelper::success(["msg" => "非企业员工无法注册"]);
//                }
                \Log::info("用户未注册，注册并直接登陆");
                //不存在用户就注册
                $server = new \App\Service\Company\BuyerService();
                $server->setLoginid($userinfo['userInfo']['nickName']);//账号
//                $server->setName($userinfo['userInfo']['nickName']);//用户名
                if ($userinfo['userInfo']['gender']){
                    $server->sexMan();
                }else{
                    $server->sexWoman();
                }
                if (isset($request["invite_id"])){
                    $count = \App\Models\BuyerModel::where("invite_user",$request["invite_id"])->count();
                    if ($count&&$count>5){
                        //邀请人超过五人
                        $msg = "邀请人超过五人";
                    }else{
                        $server->setInviteUser($request["invite_id"]);
                    }
                }
                $server->setProvince($userinfo['userInfo']['province']);
                $server->setHeadImg($userinfo['userInfo']['avatarUrl']);
                $server->setCity($userinfo['userInfo']['city']);
//                $server->setArea($request['userinfo']['rawData']['nickName']);
                $server->setWechat($r['openid']);//微信open_id
                if (isset($request["company_id"])){
                    $companyModel = \App\Models\CompanyModel::where("company_id",$request['company_id'])->first();
                    $server->setCompany($companyModel);
                }
                $model = $server->save();
            }else{
                \Log::info("用户已注册，直接登陆");
                $server = new \App\Service\Company\BuyerService($buyerModel);
                $server->setHeadImg($userinfo['userInfo']['avatarUrl']);
                if (isset($request['company_id'])){
                    $companyModel = \App\Models\CompanyModel::where("company_id",$request['company_id'])->first();
                    $server->setCompany($companyModel);
                }
                $model = $server->save();
            }
            \DB::commit();
            return \ResponseHelper::success([
                \BuyerSessionHelper::Key => \BuyerSessionHelper::set($model),
                "msg" => $msg,
            ]);
        }else{
            \DB::rollBack();
            return \ResponseHelper::error("登陆失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 返回用户姓名
     */
    public function getUser()
    {
        $request = Request::all();
        if ($request["buyer_id"])
            $model = \App\Models\BuyerModel::where("buyer_id",$request["buyer_id"])->first();
        return \ResponseHelper::success([
            "ret"=>$model->real_name,
        ]);
    }

    /**
     * @return mixed
     * 企业信息
     */
    public function getCompanyInfo()
    {
        $request = \Request::all();
        $model = \App\Models\CompanyModel::where("company_id",$request['company_id'])->first();
        return \ResponseHelper::success([
            "ret"=>$model,
        ]);
    }

    //发送模板消息
    public function postSeedTemp()
    {
        $request = \Request::all();
        if( $request['openid'] == false || $request['form_id'] == false){
            return \ResponseHelper::error("缺少参数!",NULL,NULL,500);
        }
        $array = array(
            'touser'       => $request['openid'],
            'template_id'  => '',
            'page'         => 'pages/home/home',
            'form_id'      => $request['form_id'],
            'keyword1'     => '卖家正在积极准备商品',
            'keyword2'     => '顺丰快递',
            'keyword3'     => '4324242342',
            'keyword4'     => 'S123456789',
            'keyword5'     => '你的物流状态已更新'
        );
        return \ResponseHelper::success([
            'result' => \WxHelper::seedTempMessage($array,'logisticsMsg')
        ]);
    }

    /**
     * @return mixed
     * 微信支付回调
     */
    public function postPayCallback($buyerId,$flag=0)
    {
        \Log::info("用户ID：".$buyerId);
//        $payCallBack["out_trade_no"] = "kJWWPcG7FM1S2kvejBkcRD0R";
//        $payCallBack["transaction_id"] = "4200000255201901070656950948";
//        $payCallBack["total_fee"] = 1;
        $payCallBack = \DataBaseHelper::xmlToArray(file_get_contents("php://input"));
        \Log::info($payCallBack);
        $sign = \WxHelper::sign($payCallBack,config("company.key"));
        if ($payCallBack["sign"] != $sign){
            \Log::info("签名验证失败");
            return;
        }
        \Log::info("支付回调：".json_encode($payCallBack));
        \DB::beginTransaction();
        try{
            $buyerModel = \App\Models\BuyerModel::where("buyer_id",$buyerId)->first();
            $model = \App\Models\OrderModel::where("order_sn",$payCallBack["out_trade_no"])->first();
            $orderServer = new \App\Service\Seller\OrderService($model);
            $subModel = \App\Models\OrderSubModel::where("order_sn",$payCallBack["out_trade_no"])->get();
            $detailModel = \App\Models\OrderDetailModel::where("order_sn",$payCallBack["out_trade_no"])->get();
            if ($model->pay_status == \App\Models\OrderModel::statusPay){
                //已支付
                return \ResponseHelper::error("订单已支付",NULL,NULL,500);
            }
            foreach ($subModel as $k => $v){
                //修改子订单状态与支付金额
                $orderSubServer = new \App\Service\Seller\OrderSubService($v);
                $orderSubServer->setStatusPay();
                $orderSubServer->setPaymentMoney($v->need_pay_money);
                $orderSubServer->save();
                //冻结库存扣除
                $model = \App\Models\SkuPropertiesModel::where("sku_code",$detailModel[$k]->sku_code)->first();
                $skuPropertiesServer = new \App\Service\Seller\SkuPropertiesService($model);
                $skuPropertiesServer->setFrozenStocks($model->pd_frozen_stocks-$detailModel[$k]->product_cnt);
                $skuPropertiesServer->save();
            }
            $orderServer->setStatusPay();
            $orderServer->setPaySn($payCallBack["transaction_id"]);
            $orderServer->setPaymentMoney($payCallBack["total_fee"]/100);
            $orderServer->save();

            $log = [];
            if ($flag){
                $log["user_money"] = $buyerModel->money;
                //交叉支付,修改账户余额
                $buyerServer = new \App\Service\Company\BuyerService($buyerModel);
                \Log::info("微信支付回调，用户余额".$buyerModel->money);
                $buyerServer->setMoney(-$buyerModel->money);
                $buyerServer->save();
            }

            \DB::commit();
            //刷新缓存
            \App\Data\BuyerData::flash($buyerId);
            echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";

            //日志记录
            $log["status"] = 0;
            $log["buyer"] = $buyerModel;
            $log["ip"] = \DataBaseHelper::getIp();
            $log["pay_sn"] = $payCallBack["transaction_id"];
            $log["order_sn"] = $payCallBack["out_trade_no"];
            $log["wx_money"] = $payCallBack["total_fee"]/100;
            $log["order_type"] = \App\Models\MoneyLogModel::order;
            $log["remark"] = "支付成功";
            \Log::info("微信支付日志：".json_encode($log));
            $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
            /*
            if ($request["coupon_id"]){
                $couponModel = \App\Models\CouponModel::where("coupon_id",$request["coupon_id"])->first();
                $amount = $model->payment_money-$couponModel->denomination;
            }
            $amount = $model->payment_money;
            $buyerModel = \App\Models\BuyerModel::where("buyer_id",$model->buyer_id)->first();
            $buyerServer = new \App\Service\Company\BuyerService($buyerModel);
            $buyerServer->setMoney(-$amount);
            $buyerServer->save();
            $orderServer->setPaymentTime();
            $orderServer->setStatusPay();
            $orderServer->save();*/
        }catch (\Exception $e){
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @return mixed
     * 微信充值回调
     */
    public function postRechargeCallback($buyerId)
    {
        \Log::info("用户ID：".$buyerId);
        $buyerModel = \App\Models\BuyerModel::where("buyer_id",$buyerId)->first();
//        $payCallBack["out_trade_no"] = "kJWWPcG7FM1S2kvejBkcRD0R";
//        $payCallBack["transaction_id"] = "4200000255201901070656950948";
//        $payCallBack["total_fee"] = 1;
        $payCallBack = \DataBaseHelper::xmlToArray(file_get_contents("php://input"));
        \Log::info($payCallBack);
        $sign = \WxHelper::sign($payCallBack,config("company.key"));
        if ($payCallBack["sign"] != $sign){
            \Log::info("签名验证失败");
            return;
        }
        \Log::info("充值回调：".json_encode($payCallBack));
        \DB::beginTransaction();
        try{
            //修改用户余额
            $server = new \App\Service\Company\BuyerService($buyerModel);
            $server->setMoney($payCallBack["total_fee"]/100);
            $server->save();

            $orderRechargeModel = \App\Models\OrderRechargeModel::where("order_recharge_sn",$payCallBack["out_trade_no"])->first();
            $server = new \App\Service\Api\OrderRechargeService($orderRechargeModel);
            $server->setPayTime();
            $server->setPayPrice(round($payCallBack["total_fee"]/100,2));
            $server->setPaySn($payCallBack["transaction_id"]);
            $server->setSuccess();
            $server->save();
            \DB::commit();

            //刷新缓存
            \App\Data\BuyerData::flash($buyerId);
            echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";

            //日志记录
            $log["order_type"] = \App\Models\MoneyLogModel::orderRecharge;
            $log["status"] = \App\Models\MoneyLogModel::statusRecharge;
            $log["type"] = \App\Models\MoneyLogModel::userRecharge;
            $log["buyer"] = $buyerModel;
            $log["ip"] = \DataBaseHelper::getIp();
            $log["pay_sn"] = $payCallBack["transaction_id"];
            $log["order_sn"] = $payCallBack["out_trade_no"];
            $log["wx_money"] = $payCallBack["total_fee"]/100;
            $log["remark"] = "充值成功";
            \Log::info("微信充值日志：".json_encode($log));
            $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
            /*
            if ($request["coupon_id"]){
                $couponModel = \App\Models\CouponModel::where("coupon_id",$request["coupon_id"])->first();
                $amount = $model->payment_money-$couponModel->denomination;
            }
            $amount = $model->payment_money;
            $buyerModel = \App\Models\BuyerModel::where("buyer_id",$model->buyer_id)->first();
            $buyerServer = new \App\Service\Company\BuyerService($buyerModel);
            $buyerServer->setMoney(-$amount);
            $buyerServer->save();
            $orderServer->setPaymentTime();
            $orderServer->setStatusPay();
            $orderServer->save();*/
        }catch (\Exception $e){
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * 取消订单微信退款回调
     */
    public function postPayRefundCallback($buyerId){
        \Log::info("用户ID：".$buyerId);
//        $buyerModel = \App\Models\BuyerModel::where("buyer_id",$buyerId)->first();
//        $payCallBack["out_trade_no"] = "kJWWPcG7FM1S2kvejBkcRD0R";
//        $payCallBack["transaction_id"] = "4200000255201901070656950948";
//        $payCallBack["total_fee"] = 1;
        $payCallBack = \DataBaseHelper::xmlToArray(file_get_contents("php://input"));
        \Log::info($payCallBack);
        $md5_key = md5(config("company.key"));
        $reqInfoXml = openssl_decrypt(base64_decode($payCallBack["req_info"]),'AES-256-ECB', $md5_key, 1, '');
        $reqInfo = "";
        if($reqInfoXml){
            $reqInfo = \DataBaseHelper::xmlToArray($reqInfoXml);
        }
        \Log::info("返回数据-----");
        \Log::info($reqInfo);
        if ($payCallBack["return_code"] == "SUCCESS"){
            //回调通知成功
            if ($reqInfo["refund_status"] == "SUCCESS"){
                \DB::beginTransaction();
                try{
                    //退款成功
                    $skuUniqueCodes = [];
                    //查找该总订单,子订单，订单详情
                    $model = \App\Models\OrderModel::where("order_sn",$reqInfo["out_trade_no"])->first();
                    $orderRefundModel = \App\Models\OrderRefundModel::where("order_sn",$reqInfo["out_trade_no"])->first();
                    $orderServer = new \App\Service\Seller\OrderService($model);
                    $orderRefundServer = new \App\Service\Api\OrderRefundService($orderRefundModel);
                    $subModel = \App\Models\OrderSubModel::where("order_sn",$reqInfo["out_trade_no"])->get();
                    $detailModel = \App\Models\OrderDetailModel::where("order_sn",$reqInfo["out_trade_no"])->get();
                    //修改总订单状态为失效
                    $orderServer->setStatusInactive();
                    $orderServer->setStatusRefund();
//                    $orderServer->setOrderRemark($model->order_remark);
                    $orderServer->save();

                    //退款单状态修改
                    $orderRefundServer->setRefunded();
                    $orderRefundServer->save();

                    foreach ($subModel as $k => $v){
                        //修改子订单状态为失效
                        $orderSubServer = new \App\Service\Seller\OrderSubService($v);
                        $orderSubServer->setStatusInactive();
                        $orderSubServer->setStatusRefund();
                        $orderSubServer->setOrderRemark($model->order_remark);
                        $orderSubServer->save();
                        //将sku唯一code放入数组
                        $skuUniqueCodes[$detailModel[$k]->sku_code] = $detailModel[$k]->product_cnt;//键sku唯一code放入数组，值购买数量
                    }

                    //回滚库存
                    foreach ($skuUniqueCodes as $k => $v){
                        //若不支付或支付超时，pd_frozen_stocks减N,pd_stocks加N
                        $model = \App\Models\SkuPropertiesModel::where("sku_code",$k)->first();
                        $server = new \App\Service\Seller\SkuPropertiesService($model);
                        $server->setStocks($model->pd_stocks+$v);
                        $server->setFrozenStocks($model->pd_frozen_stocks-$v);
                        $server->save();
                    }
                    \DB::commit();
                    //刷新缓存
                    \App\Data\BuyerData::flash($buyerId);
                    echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
                }catch (\Exception $e){
                    \DB::rollBack();
                    \Log::info($e);
                    throw new \App\Exceptions\AppException("修改退款状态异常");
                }
            }else{
                throw new \App\Exceptions\AppException("退款失败");
            }
        }
    }

    /**
     * 微信退货退款回调
     */
    public function postPayReturnGoodsCallback($buyerId)
    {
        \Log::info("用户ID：".$buyerId);
//        $buyerModel = \App\Models\BuyerModel::where("buyer_id",$buyerId)->first();
//        $payCallBack["out_trade_no"] = "kJWWPcG7FM1S2kvejBkcRD0R";
//        $payCallBack["transaction_id"] = "4200000255201901070656950948";
//        $payCallBack["total_fee"] = 1;
        $payCallBack = \DataBaseHelper::xmlToArray(file_get_contents("php://input"));
        \Log::info($payCallBack);
        $md5_key = md5(config("company.key"));
        $reqInfoXml = openssl_decrypt(base64_decode($payCallBack["req_info"]),'AES-256-ECB', $md5_key, 1, '');
        $reqInfo = "";
        if($reqInfoXml){
            $reqInfo = \DataBaseHelper::xmlToArray($reqInfoXml);
        }
        \Log::info("返回数据-----");
        \Log::info($reqInfo);
        if ($payCallBack["return_code"] == "SUCCESS"){
            //回调通知成功
            if ($reqInfo["refund_status"] == "SUCCESS"){
                \DB::beginTransaction();
                try{
                    //退款成功
                    //查找该总订单,子订单，订单详情
                    $orderRefundModel = \App\Models\OrderRefundModel::where("order_refund_sn",$reqInfo["out_refund_no"])->first();
//                    $orderServer = new \App\Service\Seller\OrderService($model);
                    $orderRefundServer = new \App\Service\Api\OrderRefundService($orderRefundModel);
                    $subModel = \App\Models\OrderSubModel::where("order_sub_sn",$orderRefundModel->order_sub_sn)->first();
                    //修改总订单状态为失效
//                    $orderServer->setStatusInactive();
//                    $orderServer->setStatusRefund();
//                    $orderServer->setOrderRemark($model->order_remark);
//                    $orderServer->save();

                    //退款单状态修改
                    $orderRefundServer->setRefunded();
                    $orderRefundServer->save();

                    $orderSubServer = new \App\Service\Seller\OrderSubService($subModel);
                    $orderSubServer->setStatusRefund();
                    $orderSubServer->save();

                    $model = \App\Models\OrderReturnsModel::where("order_sub_sn",$orderRefundModel->order_sub_sn)->first();
                    $server = new \App\Service\Api\OrderReturnsService($model);
                    $server->setRefundTime();
                    $server->setRefunded();
                    $server->save();
                    \DB::commit();
                    //刷新缓存
                    \App\Data\BuyerData::flash($buyerId);
                    echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
                }catch (\Exception $e){
                    \DB::rollBack();
                    \Log::info($e);
                    throw new \App\Exceptions\AppException("修改退款状态异常");
                }
            }else{
                throw new \App\Exceptions\AppException("退款失败");
            }
        }
    }
}