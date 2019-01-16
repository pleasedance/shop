<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 11:23
 */

namespace App\Http\Controllers\Seller\SellerAdmin;


class OrderController extends BaseController
{
    /**
     * 订单管理
     */
    public function getOrder()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\OrderSubModel::where("seller_id", $this->curUser->seller_id)
            ->orderBy('created_at','desc')
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/order", $res);
    }

    /**
     * @param $orderSn
     * 订单详情
     */
    public function getOrderDetail($orderSn)
    {
        $res = [];
        $res['model'] = \App\Models\OrderModel::where("order_sn",$orderSn)->first();
        return \View::make();
    }

    /**
     * @param $id
     * 订单取消
     */
    public function putOrderCancel($id)
    {
        $model = \App\Models\OrderSubModel::where("order_sub_id",$id)->first();
        $server = new \App\Service\Seller\OrderSubService($model);
        $orderSubModel = $server->setStatusInactive();
        if ($orderSubModel){
            return \ResponseHelper::success(["id"=>$orderSubModel->order_sub_id]);
        }else{
            return \ResponseHelper::error("订单取消失败",NULL,NULL,500);
        }
    }

    /**
     * @param $orderSn
     * 订单发货
     */
    public function putOrderSend($orderSn)
    {
        \DB::beginTransaction();
        $request = \Request::all();
        if(!$request["shipping_comp_name"]){
            return \ResponseHelper::error("请填写快递公司名称",NULL,NULL,500);
        }
        if(!$request["shipping_sn"]){
            return \ResponseHelper::error("请填写快递单号",NULL,NULL,500);
        }
        //修改子订单
        $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSn)
            ->with("order")
            ->first();
        $server = new \App\Service\Seller\OrderSubService($model);
        $server->setStatusSend();
        $server->setShippingTime();
        $server->setShippingCompName($request["shipping_comp_name"]);
        $server->setShippingCompCode($request["shipping_comp_code"]);
        $server->setShippingSn($request["shipping_sn"]);
        $orderSubModel = $server->save();

        $query = \App\Models\OrderSubModel::where("order_sn",$model->order->order_sn);
        $total = $query->count();
        $sendTotal = $query->where("send_status",\App\Models\OrderSubModel::statusSend)->count();
        if ($total == $sendTotal){
            //修改总订单
            $server = new \App\Service\Seller\OrderService($model->order);
            $server->setStatusSend();
            $server->setShippingTime();
            $server->save();
        }

        //发货单插入
        $server = new \App\Service\Api\OrderShipService();
        $orderDetailmodel = \App\Models\OrderDetailModel::where("order_sub_sn",$orderSn)->first();
        $server->setSendTime();
        $server->setOrderSubSn($model);
        $server->setOrderDetail($orderDetailmodel);
        $server->setShippingCompName($request["shipping_comp_name"]);
        $server->setShippingCompCode($request["shipping_comp_code"]);
        $server->setShippingSn($request["shipping_sn"]);
        $orderShip = $server->save();
        if ($orderShip){
            \DB::commit();
            return \ResponseHelper::success(["id"=>$orderSubModel->order_sub_sn]);
        }else{
            \DB::rollBack();
            return \ResponseHelper::error("订单发货失败",NULL,NULL,500);
        }
    }

    /**
     * @param $orderSn
     * 订单地址修改
     */
    public function putOrderChangeAddr($orderSn)
    {
        $request = \Reuqest::all();
        $model = \App\Models\OrderModel::where("order_sn",$orderSn)->first();
        $server = new \App\Service\Seller\OrderService($model);
        $server->setProvince($request['receive_province']);
        $server->setCity($request['receive_city']);
        $server->setArea($request['receive_area']);
        $server->setAddress($request['receive_address']);
        $orderModel = $server->save();
        if ($orderModel){
            return \ResponseHelper::success(["id"=>$orderModel->order_sn]);
        }else{
            return \ResponseHelper::error("订单地址修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $orderSn
     * 订单改价
     */
    public function putOrderChangeMoney($orderSn)
    {
        $request = \Reuqest::all();
        $model = \App\Models\OrderModel::where("order_sn",$orderSn)->first();
        $server = new \App\Service\Seller\OrderService($model);
        $server->setPaymentMoney($request['payment_money']);
        $orderModel = $server->save();
        if ($orderModel){
            return \ResponseHelper::success(["id"=>$orderModel->order_sn]);
        }else{
            return \ResponseHelper::error("订单改价失败",NULL,NULL,500);
        }
    }

    /**
     * @param $orderSn
     * @return mixed]
     * 收货
     */
    public function putOrderReceipt($orderSn)
    {
        $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSn)->first();
        $server = new \App\Service\Seller\OrderSubService($model);
        $server->setIsReceipt();
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->order_sn]);
        }else{
            return \ResponseHelper::error("收货失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 退货列表
     */
    public function getOrderReturns()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['address'] = \App\Models\SellerAddressModel::where("seller_id",$this->curUser->seller_id)
            ->where("is_default",\App\Models\SellerAddressModel::defaultActive)
            ->where("del_status",\App\Models\SellerAddressModel::delInactive)
            ->first();
        $list = \App\Models\OrderReturnsModel::where("seller_id",$this->curUser->seller_id)
            ->orderBy("created_at","desc")
            ->with("orderReturnsDetail")
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $list;
        return \View::make("seller/admin/orderreturns", $res);
    }

    /**
     * 同意申请
     */
    public function putOrderAgree($orderSubSn="")
    {
        $res = [];
        $res['user'] = $this->curUser;
        \DB::beginTransaction();
        try{
            $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Seller\OrderSubService($model);
            $server->setIsDeal();
            $server->save();
            $model = \App\Models\OrderReturnsModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Api\OrderReturnsService($model);
            $server->setReturnGoodsing();
            $server->setDelTime();
            $server->save();
            \DB::commit();
            return \ResponseHelper::success(["id"=>$orderSubSn]);
        }catch (\Exception $e){
            \DB::rollBack();
            return \ResponseHelper::error("同意申请异常",NULL,NULL,500);
        }
    }

    /**
     * 拒绝申请
     */
    public function putOrderRefuse($orderSubSn="")
    {
        $request = \Request::all();//
        $res = [];
        $res['user'] = $this->curUser;
        \DB::beginTransaction();
        try{
            $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Seller\OrderSubService($model);
            $server->setRefuseDeal();
            $server->save();
            $model = \App\Models\OrderReturnsModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Api\OrderReturnsService($model);
            $server->setRefuseReason($request["refuse_reason"]);
            $server->setRefuseDeal();
            $server->setDelTime();
            $server->save();
            \DB::commit();
            return \ResponseHelper::success(["id"=>$orderSubSn]);
        }catch (\Exception $e){
            \DB::rollBack();
            return \ResponseHelper::error("拒绝申请异常",NULL,NULL,500);
        }
    }

    /**
     * 确认退货
     */
    public function putOrderConfirm($orderSubSn="")
    {
        $res = [];
        $res['user'] = $this->curUser;
        \DB::beginTransaction();
        try{
            $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Seller\OrderSubService($model);
            $server->setStatusReturnGoods();
            $server->save();
            $model = \App\Models\OrderReturnsModel::where("order_sub_sn",$orderSubSn)->first();
            $server = new \App\Service\Api\OrderReturnsService($model);
            $server->setReturnGoodsed();
            $server->setReturnGoodsTime();
            $server->save();
            \DB::commit();
            return \ResponseHelper::success(["id"=>$orderSubSn]);
        }catch (\Exception $e){
            \DB::rollBack();
            return \ResponseHelper::error("确认退货异常",NULL,NULL,500);
        }
    }

    /**
     * @param string $orderSubSn
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 退款
     */
    public function putOrderRefund($orderSubSn="")
    {
        \Log::info("退款订单号：".$orderSubSn);
        $request = \Request::all();
        if (!$request["money"]){
            return \ResponseHelper::error("金额输入失败",NULL,NULL,500);
        }
        $model = \App\Models\OrderSubModel::where("order_sub_sn",$orderSubSn)
            ->with("order")
            ->with("orderReturns")
            ->first();
        if (!$model){
            return \ResponseHelper::error("订单不存在",NULL,NULL,500);
        }

        if ($request["money"] > $model->payment_money){
            return \ResponseHelper::error("退款金额不能超过支付金额",NULL,NULL,500);
        }

        \DB::beginTransaction();
        try{
            //查找该总订单,子订单，订单详情
            if ($model->order_status == \App\Models\OrderSubModel::statusInactive){
                return \ResponseHelper::error("订单已失效",NULL,NULL,500);
            }

            //已支付
            if ($model->pay_status == \App\Models\OrderSubModel::statusPay){
                $moneyLog = \App\Models\MoneyLogModel::where("order_sn",$model->order->order_sn)->first();
                $buyerModel = \App\Models\BuyerModel::where("buyer_id",$moneyLog->buyer_id)->first();

                //1.判断子订单总退货金额是否大于记录的微信金额
                if ($model->return_goods_money > $moneyLog->wx_money){
                    //1.1是，退余额
                    $buyerServer = new \App\Service\Company\BuyerService($buyerModel);
                    $buyerServer->setMoney($request["money"]);
                    $buyerServer->save();
                    $server = new \App\Service\Api\OrderReturnsService($model->orderReturns);
                    $server->setRefundTime();
                    $server->setRefunded();
                    $server->save();
                    $server = new \App\Service\Seller\OrderSubService($model);
                    $server->setStatusRefund();
                    $server->save();
                    \App\Data\BuyerData::flash($moneyLog->buyer_id);
                    \DB::commit();
                    return \ResponseHelper::success(["id"=>$orderSubSn]);
                }else{
                    /**/
                    //1.2否，判断请求金额是否大于剩余微信金额
                    $refundedMoney = \App\Models\OrderRefundModel::where("order_sub_sn",$orderSubSn)->sum("refund_money");//取出已退款微信金额
                    \Log::info("已退款微信金额：".$refundedMoney);
                    $remainMoney = $moneyLog->wx_money-$refundedMoney;
                    \Log::info("剩余微信金额：".$remainMoney);
                    if ($request["money"] > $remainMoney){
                        \Log::info("请求金额大于剩余微信金额");
                        //1.2.1是，退完剩余的微信金额并且退完超出的余额
                        $server = new \App\Service\Api\OrderRefundService();
                        $outRefundNo = str_random(24);
//                $outRefundNo = "8OCWHdxdqrF1MGA6a6KZf9jp";
                        $server->setOrderRefundSn($outRefundNo);
                        $server->setSubOrder($model);
                        $server->setOrder($model->order);
                        $server->setBuyer($buyerModel);
                        $server->setRefunding();
                        $server->setRefundMoney(round($remainMoney,2));
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
                        \Log::info("退款金额：".round($remainMoney,2));
                        $curl->setParam("total_fee",intval($moneyLog->wx_money*100));
                        $curl->setParam("refund_fee",intval($remainMoney*100));
//                    $curl->setParam("refund_fee",intval($request["money"]*100));
                        $nonceStr = str_random(32);
                        $curl->setParam("nonce_str",$nonceStr);
                        $curl->setParam("notify_url",config("company.wxPayReturnGoodsBack")."/".$moneyLog->buyer_id);

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
                            return \ResponseHelper::error("退款失败，请重新发起",NULL,NULL,500);
                        }
                        //退完超出的余额
                        $buyerServer = new \App\Service\Company\BuyerService($buyerModel);
                        $buyerServer->setMoney(round($request["money"]-$remainMoney,2));
                        $buyerServer->save();
                        \App\Data\BuyerData::flash($moneyLog->buyer_id);
                        \DB::commit();
                        return \ResponseHelper::success(["id"=>$orderSubSn]);
                    }else{
                        \Log::info("请求金额小于等于剩余微信金额");
                        //1.2.2否，退微信金额
                        $server = new \App\Service\Api\OrderRefundService();
                        $outRefundNo = str_random(24);
//                $outRefundNo = "8OCWHdxdqrF1MGA6a6KZf9jp";
                        $server->setOrderRefundSn($outRefundNo);
                        $server->setSubOrder($model);
                        $server->setOrder($model->order);
                        $server->setBuyer($buyerModel);
                        $server->setRefunding();
                        $server->setRefundMoney(round($request["money"],2));
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
                        \Log::info("退款金额：".$request["money"]);
                        $curl->setParam("total_fee",intval($moneyLog->wx_money*100));
                        $curl->setParam("refund_fee",intval($request["money"]*100));
                        $nonceStr = str_random(32);
                        $curl->setParam("nonce_str",$nonceStr);
                        $curl->setParam("notify_url",config("company.wxPayReturnGoodsBack")."/".$moneyLog->buyer_id);

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
                            return \ResponseHelper::error("退款失败，请重新发起",NULL,NULL,500);
                        }
                        /*
                        $server = new \App\Service\Api\OrderReturnsService($model);
                        $server->setRefundTime();
                        $server->setRefunded();
                        $server->save();
                        */
                        \DB::commit();
                        return \ResponseHelper::success(["id"=>$orderSubSn]);
                    }
                }
            }

            //修改总订单备注
//            $orderServer->setOrderRemark($request["remark"]);
//            $orderServer->save();
        }catch(\Exception $e){
            \DB::rollBack();
            \Log::info($e);
            throw new \App\Exceptions\AppException("退款异常");
        }
    }
}