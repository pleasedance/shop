<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/20
 * Time: 10:18
 */

namespace App\Http\Controllers\Api;


use http\Env\Request;
use PHPMailer\PHPMailer\Exception;

class OrderController extends BaseController
{
    /**
     * @return mixed
     * 下单
     */
    public function postOrder()
    {
        $param = $request = \Request::all();
        \Log::info("请求参数：".json_encode($param));
        //生成订单号
        $orderSn = str_random(24);
        //请求放入MQ  ->onConnection('rabbitmq')->onQueue('test1')  ->delay(Carbon::now()->addMinutes(10)) addSeconds(5)
        $param['order_sn'] = $orderSn;
        $param['user'] = $this->curUser;

        $sumProductMoney = 0;
//        $sumPaymentMoney = 0;
//        $sumDiscountMoney = 0;
//        $sumActivityMoney = 0;
//        $invoiceNumber = str_random(16);
        \DB::beginTransaction();
        //获取收货地址model
        $buyerAddressmodel = \App\Models\BuyerAddressModel::where("id",$param["buyer_address_id"])->first();
        //创建总订单model
        $orderServer = new \App\Service\Seller\OrderService();
        try{
            $param['products'] = json_decode($param['products'],TRUE);
            $needPayMoneyTotal = 0;
            foreach ($param['products'] as $v){
                if (isset($v["cart_id"])){
                    //删除购物车
                    \App\Models\CartModel::where("cart_id",$v["cart_id"])->update(["del_status"=>\App\Models\CartModel::delActive]);
                }

                $productModel = \App\Models\ProductModel::where("product_number",$v["product_number"])->first();
                $orderSubSn = str_random(24);//子订单号
                $skuPropertiesModel = \App\Models\SkuPropertiesModel::where("sku_code",$v["sku_code"])->first();
                //计算商品总价,判断是否会员若是，取会员价
                /*
                if ($this->curUser->company_id || $this->curUser->invite_user){
                    //会员价
                    $sumProductMoney += $skuPropertiesModel->member_price*$v["cnt"];
                }else{
                    //非会员价
                    $sumProductMoney += $skuPropertiesModel->pd_price*$v["cnt"];
                }*/
                $sumProductMoney += $skuPropertiesModel->pd_price*$v["cnt"];
                //若库存不够，返回失败
                if ($skuPropertiesModel->pd_stocks < $v["cnt"]){
                    return \ResponseHelper::success(["msg"=>"库存不足"]);
//                    return \ResponseHelper::error("库存不足",NULL,NULL,500);
                }
                //获取库存service
                $server = new \App\Service\Seller\SkuPropertiesService($skuPropertiesModel);
                //库存先减商品下单的数量（pd_stocks-N）
                $server->setStocks($skuPropertiesModel->pd_stocks-$v["cnt"]);
                //冻结库存加上改数量（pd_frozen_stocks+N）
                $server->setFrozenStocks($skuPropertiesModel->pd_frozen_stocks+$v["cnt"]);
                $server->save();

                //生成子订单（N个商品，N个子订单）,生成订单详情（N个商品，N个详情）
                $server = new \App\Service\Seller\OrderSubService();
                //获取商家
                $model = \App\Models\SellerModel::where("seller_id",$v["seller_id"])->first();
                $server->setOrderSubSn($orderSubSn);
                $server->setSeller($model);
                if ($param["payment_method"]){
                    $server->setBalancePay();
                }else{
                    $server->setWxPay();
                }
                $server->setBuyer($param["user"]);
                $server->setOrderSn($param["order_sn"]);
                $server->setProductMoney($skuPropertiesModel->pd_price*$v["cnt"]);
                $server->setNeedPayMoney(round($skuPropertiesModel->pd_price*$v["cnt"],2));
                /*
                if ($this->curUser->company_id || $this->curUser->invite_user){
                    $server->setProductMoney($skuPropertiesModel->member_price*$v["cnt"]);
                    $server->setNeedPayMoney(round($skuPropertiesModel->member_price*$v["cnt"],2));
                }else{
                    $server->setProductMoney($skuPropertiesModel->pd_price*$v["cnt"]);
                    $server->setNeedPayMoney(round($skuPropertiesModel->pd_price*$v["cnt"],2));
                }*/
                switch ($param["payment_method"]){
                    case "0":
                        $server->setWxPay();
                        break;
                    case "1":
                        $server->setBalancePay();
                        break;
                }
                /*
                switch ($v["order_source"]){
                    case "0":
                        $server->setAppSource();
                        break;
                    case "1":
                        $server->setWapSource();
                        break;
                }
                */

                $server->setBuyerAddress($buyerAddressmodel);
                if (!empty($param["coupon_id"])){
                    $model = \App\Models\CoupanModel::where("coupon_id",$this->data["coupon_id"])->first();
                    $server->setCoupan($model);
                }
                if (!empty($param["activity_id"])){
                    $model = \App\Models\ActivityModel::where("activity_id",$this->data["activity_id"])->first();
                    $server->setActivity($model);
                }
                /*
                if ($this->data['invoice']){
                    //若选择发票保存发票唯一code
                    $server->setInvoiceNumber($invoiceNumber);
                }
                */
                $server->save();

                //生成订单详情
                $server = new \App\Service\Api\OrderDetailService();
                $server->setOrderSubSn($orderSubSn);
                $server->setOrderSn($param["order_sn"]);
                $server->setProduct($productModel);
                $server->setCnt($v["cnt"]);
                $server->setMoney($skuPropertiesModel->pd_price);
                $needPayMoneyTotal += round($skuPropertiesModel->pd_price*$v["cnt"],2);
                /*
                if ($this->curUser->company_id || $this->curUser->invite_user){
                    $server->setMoney($skuPropertiesModel->member_price);
                    $needPayMoneyTotal += round($skuPropertiesModel->member_price*$v["cnt"],2);
                }else{
                    $server->setMoney($skuPropertiesModel->pd_price);
                    $needPayMoneyTotal += round($skuPropertiesModel->pd_price*$v["cnt"],2);
                }*/
//                $server->setDiscountMoney($v['discount_money']);
//                $server->setDetailGrowth();
//                $server->setDetailLeGlod();
                $server->setSkuUniqueCode($skuPropertiesModel);
                $skuModel = \App\Models\SkuModel::where("sku_code",$v["sku_code"])->first();
                $server->setProductSku($skuModel);
                $server->save();
            }

            //初始化总订单model
            $orderServer->setOrderSn($param["order_sn"]);
            $orderServer->setBuyer($param["user"]);
            if ($param["payment_method"]){
                $orderServer->setBalancePay();
            }else{
                $orderServer->setWxPay();
            }
            $orderServer->setBuyerAddress($buyerAddressmodel);
            $orderServer->setProductMoney($sumProductMoney);
            $orderServer->setNeedPayMoney($needPayMoneyTotal);
            $orderServer->save();
            \DB::commit();
            //将支付超时任务丢入任务中心,设置消费时间
            $task["order_sn"] = $param["order_sn"];
            \Log::info("消息队列：".env("RABBITMQ_QUEUE_PAY_TIME"));
            $this->dispatch((new \App\Jobs\PayJob($task))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE_PAY_TIME"))->delay(\Carbon\Carbon::now()->addMinutes(30)));
            \Log::info("下单成功");
            return \ResponseHelper::success(["order_id"=>$orderSn]);
            /*
            if (!empty($this->data["coupon_id"])){
                $model = \App\Models\CoupanModel::where("coupon_id",$this->data["coupon_id"])->first();
                $orderServer->setCoupan($model);
            }
            if (!empty($this->data["activity_id"])){
                $model = \App\Models\ActivityModel::where("activity_id",$this->data["activity_id"])->first();
                $orderServer->setActivity($model);
            }
            if ($this->data['invoice']){
                //若选择发票保存发票唯一code
                $orderServer->setInvoiceNumber($invoiceNumber);
            }*/
//            $orderServer->setDiscountMoney($sumDiscountMoney);
//            $orderServer->setActivityMoney($invoiceNumber);
        }catch (\Exception $e){
            \DB::rollBack();
            \Log::info($e);
            return \ResponseHelper::error("下单异常",NULL,NULL,500);
        }
    }

    /**
     * @param string $orderSn
     * @throws \Exception
     * 订单取消
     */
    public function postCancel()
    {
        $request = \Request::all();
        if (!$request["order_id"]){
            return \ResponseHelper::error("订单不存在",NULL,NULL,500);
        }
        $orderSn = $request["order_id"];

        \DB::beginTransaction();
        try{
            /*
            $skuUniqueCodes = [];
            $subModel = \App\Models\OrderSubModel::where("order_sn",$orderSn)->get();
            $detailModel = \App\Models\OrderDetailModel::where("order_sn",$orderSn)->get();
            */
            //查找该总订单,子订单，订单详情
            $model = \App\Models\OrderModel::where("order_sn",$orderSn)->first();
            $orderServer = new \App\Service\Seller\OrderService($model);
            if ($model->order_status == \App\Models\OrderModel::statusInactive){
                return \ResponseHelper::error("订单已失效",NULL,NULL,500);
            }

            //已支付
            if ($model->pay_status == \App\Models\OrderModel::statusPay){
                \Log::info("已支付订单取消");
                $moneyLog = \App\Models\MoneyLogModel::where("order_sn",$request["order_id"])->first();
                if (isset($moneyLog->wx_money)){
                    //生成退款单
                    $outRefundNo = str_random(24);
                    $server = new \App\Service\Api\OrderRefundService();
                    $server->setOrderRefundSn($outRefundNo);
                    $server->setOrder($model);
                    $server->setBuyer($this->curUser);
                    $server->setRefunding();
                    $server->setRefundMoney(round($moneyLog->wx_money,2));
                    $server->save();

                    //调用微信退款
                    $curl = new \JSocket();
                    $curl->setRetFormat(\JSocket::retFormatXml);
                    $curl->setUrl(config("company.payRefund"));
                    $curl->setRequestType(\JSocket::retFormatXml);

                    $curl->setParam("appid",config('company.appid'));
                    $curl->setParam("mch_id",config('company.mch_id'));
                    $curl->setParam("transaction_id",$moneyLog->pay_sn);
                    $curl->setParam("out_refund_no",$outRefundNo);
                    \Log::info("退款金额：".intval($moneyLog->wx_money*100));
                    $curl->setParam("total_fee",intval($moneyLog->wx_money*100));
                    $curl->setParam("refund_fee",intval($moneyLog->wx_money*100));
                    $nonceStr = str_random(32);
                    $curl->setParam("nonce_str",$nonceStr);
                    $curl->setParam("notify_url",config("company.wxPayRefundBack")."/".$this->curUser->buyer_id);

                    //验签生成
                    $sign = \WxHelper::sign($curl->getParam(),config("company.key"));
                    \Log::info("sign:".$sign);
                    \Log::info($curl->getParam());
                    \Log::info("key:".config("company.key"));
                    $curl->setParam("sign",$sign);

                    $curl->setTimeout(30);
                    $curl->setMethod(\JSocket::methodPost);

                    $ssl = [
                        "cert"=>"/code/wxcert/apiclient_cert.pem",
                        "key"=>"/code/wxcert/apiclient_key.pem",
                    ];
                    $curl->ssl($ssl);
                    $curl->exe();
                    $r = $curl->getRet();
                    \Log::info($r);
                    if ($r["return_code"]!="SUCCESS"){
                        return \ResponseHelper::error("取消失败，请重新发起",NULL,NULL,500);
                    }

                    /*
                    //再次签名
                    $ret = [];
                    $ret['timeStamp'] = time();
                    $ret['package'] = "prepay_id=".$r["prepay_id"];
                    $ret['nonceStr'] = $nonceStr;
                    $ret['signType'] = "MD5";
                    $ret['paySign'] = MD5("appId=".config('company.appid')."&nonceStr=".$nonceStr."&package=prepay_id=".$r["prepay_id"]."&signType=MD5&timeStamp=".time()."&key=".config("company.key"));
                    */
                }
                if (isset($moneyLog->user_money)){
                    $buyerServer = new \App\Service\Company\BuyerService($this->curUser);
                    $buyerServer->setMoney($moneyLog->user_money);
                    $buyerServer->save();
                    \BuyerSessionHelper::flush();
                    //修改总订单状态为失效
                    $orderServer->setStatusInactive();
                    $orderServer->setStatusRefund();
                    $orderServer->setOrderRemark($request["remark"]);
                    $orderServer->save();
                    $list = \App\Models\OrderSubModel::where("order_sn",$orderSn)->get();
                    if (!empty($list)){
                        //修改子订单状态为失效
                        foreach ($list as $v)
                            $server = new \App\Service\Seller\OrderSubService($v);
                        $server->setStatusInactive();
                        $server->setStatusRefund();
                        $server->setOrderRemark($request["remark"]);
                        $server->save();
                    }
                }
                \DB::commit();
                return \ResponseHelper::success(["order_id"=>$orderSn]);
            }else{
                //修改总订单状态为失效
                $orderServer->setStatusInactive();
//                $orderServer->setStatusRefund();
                $orderServer->setOrderRemark($request["remark"]);
                $orderServer->save();
                $list = \App\Models\OrderSubModel::where("order_sn",$orderSn)->get();
                if (!empty($list)){
                    //修改子订单状态为失效
                    foreach ($list as $v)
                        $server = new \App\Service\Seller\OrderSubService($v);
                    $server->setStatusInactive();
//                    $server->setStatusRefund();
                    $server->setOrderRemark($request["remark"]);
                    $server->save();
                }
                \DB::commit();
                return \ResponseHelper::success(["order_id"=>$orderSn]);
            }
        }catch(\Exception $e){
            \DB::rollBack();
            \Log::info($e);
            throw new \App\Exceptions\AppException("订单取消异常");
        }
    }

    /**
     * @return mixed
     * 支付
     */
    public function postPay()
    {
        $request = \Request::all();
        \Log::info("支付请求参数：");
        \Log::info($request);
        //查找该总订单,子订单，订单详情
        $model = \App\Models\OrderModel::where("order_sn",$request["order_id"])->first();
        if ($model->order_status == \App\Models\OrderModel::statusInactive){
            //无效订单
            return \ResponseHelper::error("无效订单",NULL,NULL,500);
        }

        if ($model->pay_status == \App\Models\OrderModel::statusPay){
            //已支付
            return \ResponseHelper::error("订单已支付",NULL,NULL,500);
        }
        $orderServer = new \App\Service\Seller\OrderService($model);
        /*
        $subModel = \App\Models\OrderSubModel::where("order_sn",$request["order_id"])->get();
        $detailModel = \App\Models\OrderDetailModel::where("order_sn",$request["order_id"])->get();
        $amount = 0;
        if ($request["coupon_id"]){
            $couponModel = \App\Models\CouponModel::where("coupon_id",$request["coupon_id"])->first();
            $amount = $model->payment_money-$couponModel->denomination;
        }
        */

        //用户余额减 商品金额减优惠券金额的差 大于0 调用微信支付API扣款（生成微信支付订单）
        \Log::info(date("Y-m-d H:i:s")."支付类型：".$model->payment_method);
        \Log::info(date("Y-m-d H:i:s")."支付金额：".$model->product_money);
        if (!$model->payment_method){
            $amount = $model->product_money;
            \Log::info(date("Y-m-d H:i:s")."微信支付金额：".$amount);
            //调用微信，支付微信红包金额
            $curl = new \JSocket();
            $curl->setRetFormat(\JSocket::retFormatXml);
            $curl->setUrl(config("company.wxpay"));
            $curl->setRequestType(\JSocket::retFormatXml);

            $curl->setParam("appid",config('company.appid'));

            $curl->setParam("mch_id",config('company.mch_id'));

            $curl->setParam("body","test");

            $nonceStr = str_random(32);
            $curl->setParam("nonce_str",$nonceStr);

            $curl->setParam("out_trade_no",$model->order_sn);
            $curl->setParam("total_fee",round($amount*100,2));//微信支付金额
            $curl->setParam("openid",$this->curUser->wechat_openid);
            $curl->setParam("spbill_create_ip",\DataBaseHelper::getIp());
            //回调地址
            $curl->setParam("notify_url",config("company.wxpaycallback")."/".$this->curUser->buyer_id);
            //交易类型
            $curl->setParam("trade_type",config("company.wxtradetype.JSAPI"));

            //验签生成
            $sign = \WxHelper::sign($curl->getParam(),config("company.key"));
            \Log::info("sign:".$sign);
            \Log::info($curl->getParam());
            \Log::info("key:".config("company.key"));
            $curl->setParam("sign",$sign);

            $curl->setTimeout(30);
            $curl->setMethod(\JSocket::methodPost);
            $curl->exe();
            $r = $curl->getRet();
            \Log::info($r);
            if ($r["return_code"]!="SUCCESS"){
                return \ResponseHelper::error("支付失败，请重新支付",NULL,NULL,500);
            }

            //再次签名
            $ret = [];
            $ret['timeStamp'] = time();
            $ret['package'] = "prepay_id=".$r["prepay_id"];
            $ret['nonceStr'] = $nonceStr;
            $ret['signType'] = "MD5";
            $ret['paySign'] = MD5("appId=".config('company.appid')."&nonceStr=".$nonceStr."&package=prepay_id=".$r["prepay_id"]."&signType=MD5&timeStamp=".time()."&key=".config("company.key"));
            return \ResponseHelper::success(["ret"=>$ret]);
        }else{
            $amount = $this->curUser->money - $model->product_money;
            \Log::info(date("Y-m-d H:i:s").":微信支付金额：".round($amount,2));
            if ($amount<0){
                //调用微信，支付微信红包金额
                $curl = new \JSocket();
                $curl->setRetFormat(\JSocket::retFormatXml);
                $curl->setUrl(config("company.wxpay"));
                $curl->setRequestType(\JSocket::retFormatXml);

                $curl->setParam("appid",config('company.appid'));

                $curl->setParam("mch_id",config('company.mch_id'));

                $curl->setParam("body","test");

                $nonceStr = str_random(32);
                $curl->setParam("nonce_str",$nonceStr);

                $curl->setParam("out_trade_no",$model->order_sn);
                $curl->setParam("total_fee",-round($amount*100,2));//微信支付金额
                $curl->setParam("openid",$this->curUser->wechat_openid);
                $curl->setParam("spbill_create_ip",\DataBaseHelper::getIp());
                //回调地址
                $curl->setParam("notify_url",config("company.wxpaycallback")."/".$this->curUser->buyer_id."/1");
                //交易类型
                $curl->setParam("trade_type",config("company.wxtradetype.JSAPI"));

                //验签生成
                $sign = \WxHelper::sign($curl->getParam(),config("company.key"));
                \Log::info("sign:".$sign);
                \Log::info($curl->getParam());
                \Log::info("key:".config("company.key"));
                $curl->setParam("sign",$sign);

                $curl->setTimeout(30);
                $curl->setMethod(\JSocket::methodPost);
                $curl->exe();
                $r = $curl->getRet();
                \Log::info($r);
                if ($r["return_code"]!="SUCCESS"){
                    return \ResponseHelper::error("支付失败，请重新支付",NULL,NULL,500);
                }

                //再次签名
                $ret = [];
                $ret['timeStamp'] = time();
                $ret['package'] = "prepay_id=".$r["prepay_id"];
                $ret['nonceStr'] = $nonceStr;
                $ret['signType'] = "MD5";
                $ret['paySign'] = MD5("appId=".config('company.appid')."&nonceStr=".$nonceStr."&package=prepay_id=".$r["prepay_id"]."&signType=MD5&timeStamp=".time()."&key=".config("company.key"));
                return \ResponseHelper::success(["ret"=>$ret]);
            }else{
                //扣除用户余额
                \DB::beginTransaction();
                try{
                    \Log::info("扣除用户余额：".$amount);
                    $buyerServer = new \App\Service\Company\BuyerService($this->curUser);
                    $buyerServer->setMoney(-$model->product_money);
                    $buyerServer->save();
                    $orderServer->setPaymentMoney($model->product_money);
                    $orderServer->setPaymentTime();
                    $orderServer->setStatusPay();
                    $orderServer->save();
                    $list = \App\Models\OrderSubModel::where("order_sn",$request["order_id"])->get();
                    if (!empty($list)){
                        foreach ($list as $v){
                            $orderSubServer = new \App\Service\Seller\OrderSubService($v);
                            $orderSubServer->setPaymentMoney($v->product_money);
                            $orderSubServer->setPaymentTime();
                            $orderSubServer->setStatusPay();
                            $orderSubServer->save();
                        }
                    }
                    \BuyerSessionHelper::flush();
                    $log["status"] = 0;
                    $log["user_money"] = $model->product_money;
                    $log["buyer"] = $this->curUser;
                    $log["ip"] = \DataBaseHelper::getIp();
                    $log["order_sn"] = $model->order_sn;
                    $log["order_type"] = \App\Models\MoneyLogModel::order;
                    $log["remark"] = "支付成功";
                    $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
                    \DB::commit();
                    return \ResponseHelper::success("支付成功");
                }catch(\Exception $e){
                    $log["status"] = 0;
                    $log["user_money"] = $model->product_money;
                    $log["buyer"] = $this->curUser;
                    $log["ip"] = \DataBaseHelper::getIp();
                    $log["order_sn"] = $model->order_sn;
                    $log["order_type"] = \App\Models\MoneyLogModel::order;
                    $log["remark"] = "支付失败";
                    $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
                    \DB::rollBack();
                    return \ResponseHelper::error("支付失败，请重新支付",NULL,NULL,500);
                }
            }
        }
    }

    /**
     * @return mixed
     * 订单信息
     */
    public function postOrderInfo()
    {
        $request = \Request::all();
        $model = \App\Models\OrderModel::where("order_sn",$request["order_id"])->first();
        return \ResponseHelper::success(["pay_status"=>$model->pay_status]);
    }

    /**
     * @return mixed
     * 删除订单
     */
    public function postOrderDel()
    {
        \DB::beginTransaction();
        try{
            $request = \Request::all();
            if (!$request["order_id"]){
                return \ResponseHelper::error("订单不存在",NULL,NULL,500);
            }
            \App\Models\OrderModel::where("order_sn",$request["order_id"])->update(["order_status"=>\App\Models\OrderModel::statusDel]);
            \App\Models\OrderSubModel::where("order_sn",$request["order_id"])->update(["order_status"=>\App\Models\OrderSubModel::statusDel]);
            \DB::commit();
            return \ResponseHelper::success(["order_id"=>$request["order_id"]]);
        }catch (\Exception $e){
            \log::info($e);
            \DB::rollBack();
            return \ResponseHelper::error("删除失败，请重新删除",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 订单列表
     */
    public function getOrders()
    {
        $request = \Request::all();
        $query = \App\Models\OrderModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("order_status","!=",\App\Models\OrderModel::statusDel)
            ->with("orderDetail")
            ->with("orderSub")
            ->orderBy('created_at','desc');
        if (isset($request["pay_no"])){
            $query->where("order_status",\App\Models\OrderModel::statusActive);
            $query->where("pay_status",\App\Models\OrderModel::statusNoPay);
        }
        if (isset($request["send_no"])){
            $query->where("order_status",\App\Models\OrderModel::statusActive);
            $query->where("pay_status",\App\Models\OrderModel::statusPay);
            $query->where("send_status",\App\Models\OrderModel::statusNoSend);
        }
        if (isset($request["receipt_no"])){
            $query->where("order_status",\App\Models\OrderModel::statusActive);
            $query->where("send_status",\App\Models\OrderModel::statusSend);
            $query->where("pay_status",\App\Models\OrderModel::statusPay);
            $query->where("receipt_status",\App\Models\OrderModel::noReceipt);
        }
        if (isset($request["evaluation_no"])){
            $query->where("order_status",\App\Models\OrderModel::statusActive);
            $query->where("send_status",\App\Models\OrderModel::statusSend);
            $query->where("receipt_status",\App\Models\OrderModel::isReceipt);
            $query->where("pay_status",\App\Models\OrderModel::statusPay);
            $query->where("evaluation_status",\App\Models\OrderModel::noEvaluation);
        }
        $total = $query->count();
        $query->offset(($request['offset']-1)*$request['limit']);
        $query->limit($request['limit']);
        $result = $query->get();
        foreach ($result as $k => $v){
            foreach ($v['orderDetail'] as $kk => $vv){
//                echo $result[$k]["orderDetail"][$kk];
                $result[$k]["orderDetail"][$kk]->properties = \App\Models\SkuPropertiesModel::where("sku_code",$vv->sku_code)->first();
                $result[$k]["orderDetail"][$kk]->market_price = \App\Models\ProductModel::where("product_number",$vv->product_number)->value("market_price");
            }
        }
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
        ]);
    }

    /**
     * @return mixed
     * 订单详情
     */
    public function getOrderDetail()
    {
        $request = \Request::all();
        $orderModel = \App\Models\OrderModel::where("order_sn",$request["order_id"])->first();
        $query = \App\Models\OrderDetailModel::where("order_sn",$request["order_id"])
            ->with("skuProperties")
            ->with("product")
            ->with("orderSub");
        $total = $query->count();
        $result = $query->get();
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
            "order"=>$orderModel,
        ]);
    }

    /**
     * @return mixed
     * 收货
     */
    public function postOrderReceipt()
    {
        \DB::beginTransaction();
        try{
            $request = \Request::all();
            \App\Models\OrderModel::where("order_sn",$request["order_id"])->update(["receipt_status"=>\App\Models\OrderModel::isReceipt]);
            \App\Models\OrderSubModel::where("order_sn",$request["order_id"])->update(["receipt_status"=>\App\Models\OrderSubModel::isReceipt]);
            \App\Models\OrderModel::where("order_sn",$request["order_id"])->update(["complete_time"=>date("Y-m-d H:i:s")]);
            \App\Models\OrderSubModel::where("order_sn",$request["order_id"])->update(["complete_time"=>date("Y-m-d H:i:s")]);
            $list = \App\Models\OrderDetailModel::where("order_sn",$request["order_id"])->get(["product_cnt","product_number"]);
            foreach($list as $v){
                $productModel = \App\Models\ProductModel::where("product_number",$v->product_number)->first();
                $server = new \App\Service\Seller\ProductService($productModel);
                $server->setSalesNum($productModel->sales_num+$v->product_cnt);
                $server->save();
            }
            //setSalesNum
            \DB::commit();
            return \ResponseHelper::success(["order_id"=>$request["order_id"]]);
        }catch (\Exception $e){
            \Log::info($e);
            \DB::rollBack();
            return \ResponseHelper::error("收货异常",NULL,NULL,500);
        }
    }

    /**
     * 退货申请
     */
    public function postReturn()
    {
        $request = \Request::all();
        $orderSubModel = \App\Models\OrderSubModel::where("order_sub_sn",$request["order_id"])
            ->with('order')
            ->with('orderDetail')
            ->first();
        \DB::beginTransaction();
        try{
            //修改子订单状态为申请中
            $orderSubServer = new \App\Service\Seller\OrderSubService($orderSubModel);
            $orderSubServer->setApplyDeal();
            $orderSubServer->save();
            //若子订单全部申请退货，修改总订单状态
            /*
            $query = \App\Models\OrderSubModel::where("order_sn",$orderSubModel->order->order_sn);

            $total = $query->count();
            $applyTotal = $query->where("return_goods_status",\App\Models\OrderSubModel::statusApplyReturnGoods)->count();
            if ($total == $applyTotal){
                $orderServer = new \App\Service\Seller\OrderService($orderSubModel->order);
                $orderServer->setApplyReturnGoods();
                $orderServer->save();
            }*/

            $orderReturnsServer = new \App\Service\Api\OrderReturnsService();
            $orderSn = str_random(24);
            $orderReturnsServer->setSn($orderSn);
            $orderReturnsServer->setOrder($orderSubModel->order);
            $orderReturnsServer->setOrderDetail($orderSubModel->orderDetail);
            $orderReturnsServer->setSubOrder($orderSubModel);
            $orderReturnsServer->setBuyer($this->curUser);
            $orderReturnsServer->setApplyDeal();
            $sellerAddressModel = \App\Models\SellerAddressModel::where("seller_id",$orderSubModel->seller_id)
                ->where("is_default",\App\Models\SellerAddressModel::defaultActive)
                ->first();
            $orderReturnsServer->setSellerAddress($sellerAddressModel);
            $orderReturnsModel = $orderReturnsServer->save();

            $orderReturnsDetailServer = new \App\Service\Api\OrderReturnsDetailService();
            $orderReturnsDetailServer->setOrderReturn($orderReturnsModel);
            $orderReturnsDetailServer->setOrderSub($orderSubModel);
            $orderReturnsDetailServer->setBuyer($this->curUser);
            $orderReturnsDetailServer->setOrderDetail($orderSubModel->orderDetail);
            $orderReturnsDetailServer->setReturnGoodsReason($request["reason"]);
            $orderReturnsDetailServer->setReturnGoodsDesr($request["desr"]);
            $orderReturnsDetailServer->setReturnGoodsImg(trim($request["img"],","));
            $orderReturnsDetailServer->save();
            \DB::commit();
            return \ResponseHelper::success(["order_id"=>$orderSubModel->order_sub_sn]);
        }catch (\Exception $e){
            \DB::rollBack();
            \Log::info($e);
            return \ResponseHelper::error("退货申请异常，请重新申请",NULL,NULL,500);
        }
    }

    /**
     * 退货单列表
     */
    public function getReturns()
    {
        $request = \Request::all();
        $query = \App\Models\OrderReturnsModel::where("buyer_id",$this->curUser->buyer_id)
            ->with("orderReturnsDetail")
            ->with("product");
        $total = $query->count();
        $query->offset(($request['offset']-1)*$request['limit']);
        $query->limit($request['limit']);
        $result = $query->get();
        if (isset($result)){
            foreach ($result as $k => $v){
                $result[$k]->sku_picture_url = \App\Models\SkuPropertiesModel::where("sku_code",$v->sku_code)->value("sku_picture_url");
            }
        }
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
        ]);
    }

    /**
     * @param $orderReturnSn
     * @return mixed
     * 退货单详情
     */
    public function getReturnGoods($orderSubSn)
    {
        $model = \App\Models\OrderReturnsModel::where("order_sub_sn",$orderSubSn)
            ->with("sellerAddress")
            ->first();
        return \ResponseHelper::success([
            "ret"=>$model,
        ]);
    }

    /**
     * 设置退货单快递号
     */
    public function postSetShippingSn()
    {
        $request = \Request::all();
        if (!$request["order_id"]){
            return \ResponseHelper::error("订单不存在",NULL,NULL,500);
        }
        if (!$request["shipping_sn"]){
            return \ResponseHelper::error("请填写退货快递单号",NULL,NULL,500);
        }
        $orderReturnsodel = \App\Models\OrderReturnsModel::where("order_sub_sn",$request["order_id"])->first();
        $orderReturnsServer = new \App\Service\Api\OrderReturnsService($orderReturnsodel);
        $orderReturnsServer->setShippingSn($request["shipping_sn"]);
        $orderReturnsServer->save();
        return \ResponseHelper::success([
            "id"=>$request["order_id"],
        ]);
    }
}