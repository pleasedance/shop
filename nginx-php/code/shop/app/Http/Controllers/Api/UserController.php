<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use http\Env\Request;

/**
 * Description of UserController
 *
 * @author Administrator
 */
class UserController extends BaseController {
    /**
     * @return mixed
     * 用户信息
     */
    public function getPersonal()
    {
        $companyName = \App\Models\CompanyModel::where("company_id",$this->curUser->company_id)->value("name");
        $this->curUser->company_name = $companyName;
        return \ResponseHelper::success([
            "user"=>$this->curUser,
        ]);
    }

    /**
     * @return mixed
     * 购物车列表
     */
    public function getCart()
    {
        $query= \App\Models\CartModel::where("del_status",\App\Models\CartModel::delInactive)
            ->where("buyer_id",$this->curUser->buyer_id)
            ->with("product")
            ->with("sku")
            ->with("properties");
        $total=$query->count();
        $result=$query->get();
//        $result=$query->simplePaginate(20);
        /*
         * $list=[];
        if($result->toArray()){
            foreach ($result as $value) {
                $list[]=[
                    "id"=>$value->cart_id,
                    "seller_id"=>$value->seller_id,
                    "sku_unique_code"=>$value->sku_unique_code,
                    "product_number"=>$value->product_number,
                    "buyer_id"=>$value->buyer_id,
                    "product_id"=>$value->product_id,
                    "product_amount"=>$value->product_amount,
                    "created_at"=>$value->created_at,
                    "updated_at"=>$value->updated_at,
                ];
            }
        }*/
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
        ]);
    }

    /**
     * @return mixed
     * 添加商品到购物车
     */
    public function postCart()
    {
        $request = \Request::all();
        $model = \App\Models\CartModel::where("sku_code",$request["sku_code"])
            ->where("buyer_id",$this->curUser->buyer_id)
            ->where("del_status",\App\Models\CartModel::delInactive)
            ->first();
        if ($model){
            $server = new \App\Service\Company\CartService($model);
            $server->setAmount($model->product_amount+$request["amount"]);
            $cartModel = $server->save();
        }else{
            $server = new \App\Service\Company\CartService();
            $skuPropertiesModel = \App\Models\SkuPropertiesModel::where("sku_code",$request["sku_code"])->first();
            $server->setSkuUniqueCode($skuPropertiesModel);
            $server->setAmount($request["amount"]);
            $productModel = \App\Models\ProductModel::where("product_number",$request["product_number"])->first();
            $sellerModel = \App\Models\SellerModel::where("seller_id",$productModel->pd_seller_id)->first();
            $server->setSeller($sellerModel);
            $server->setProduct($productModel);
            $server->setBuyer($this->curUser);
            $cartModel = $server->save();
        }
        if ($cartModel){
            return \ResponseHelper::success(["id"=>$cartModel->cart_id]);
        }else{
            return \ResponseHelper::error("添加失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 从购物车删除商品
     */
    public function deleteCart()
    {
        $request = \Request::all();
        $ids = json_decode($request["ids"],true);
        $r = \App\Models\CartModel::whereIn("cart_id",$ids)->update(["del_status"=>\App\Models\CartModel::delActive]);
        /*
        $server = new \App\Service\Company\CartService($model);
        $server->setDelActive();
        $cartModel = $server->save();
        */
        if ($r){
            return \ResponseHelper::success(["ret"=>"成功"]);
        }else{
            return \ResponseHelper::error("失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 充值
     */
    public function postRecharge()
    {
        try{
            \DB::beginTransaction();
            $request = \Request::all();
            \Log::info("充值金额：".$request["money"]);
            //调用微信，支付微信红包金额
            $outTradeNo = str_random(24);

            $server = new \App\Service\Api\OrderRechargeService();
            $server->setOrderRechargeSn($outTradeNo);
            $server->setBuyer($this->curUser);
            if ($this->curUser->company_id){
                $companyModel = \App\Models\CompanyModel::where("company_id",$this->curUser->company_id)->first();
                $server->setCompany($companyModel);
            }
            $server->setMoney($request["money"]);
            $server->setWxMethod();
            $server->save();
            \DB::commit();

            $curl = new \JSocket();
            $curl->setRetFormat(\JSocket::retFormatXml);
            $curl->setUrl(config("company.wxpay"));
            $curl->setRequestType(\JSocket::retFormatXml);

            $curl->setParam("appid",config('company.appid'));

            $curl->setParam("mch_id",config('company.mch_id'));

            $curl->setParam("body","test");

            $nonceStr = str_random(32);
            $curl->setParam("nonce_str",$nonceStr);

            $curl->setParam("out_trade_no",$outTradeNo);
            $curl->setParam("total_fee",$request["money"]*100);//微信支付金额$request["money"]*100
            $curl->setParam("openid",$this->curUser->wechat_openid);
            $curl->setParam("spbill_create_ip",\DataBaseHelper::getIp());
            //回调地址
            $curl->setParam("notify_url",config("company.wxrechargecallback")."/".$this->curUser->buyer_id);
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
        }catch (\Exception $e){
            \DB::rollBack();
            return \ResponseHelper::error("充值失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 充值记录
     */
    public function getRechargeLog()
    {
        $query = \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id);
        $total=$query->count();
        $result=$query->get();
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
        ]);
    }

    /**
     * @return mixed
     * 添加收货信息
     */
    public function postAddress()
    {
        $request = \Request::all();
        //$this->curUser
        $server = new \App\Service\Api\BuyerAddressService();
        $server->setName($request["name"]);
        $server->setPhone($request["phone"]);
        $server->setPostalCode($request["postal_code"]);
        $server->setProvince($request["province"]);
        $server->setCity($request["city"]);
        $server->setArea($request["area"]);
        $server->setAddress($request["address"]);
        $server->setBuyer($this->curUser);

        if ($request["is_default"]){
            \App\Models\BuyerAddressModel::where("buyer_id",$this->curUser->buyer_id)->update(["is_default"=>0]);
            $server->setDefaultActive();
        }else{
            $server->setDefaultInactive();
        }
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->id]);
        }else{
            return \ResponseHelper::error("添加失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 修改收货信息
     */
    public function putAddress()
    {
        $request = \Request::all();
        if (!$request['id']){
            return \ResponseHelper::error("没有该地址",NULL,NULL,500);
        }
        $model = \App\Models\BuyerAddressModel::where("id",$request['id'])->first();
        $server = new \App\Service\Api\BuyerAddressService($model);
        $server->setName($request["name"]);
        $server->setPhone($request["phone"]);
        $server->setPostalCode($request["postal_code"]);
        $server->setProvince($request["province"]);
        $server->setCity($request["city"]);
        $server->setArea($request["area"]);
        $server->setAddress($request["address"]);
        $server->setBuyer($this->curUser);

        if ($request["is_default"]){
            \App\Models\BuyerAddressModel::where("buyer_id",$this->curUser->buyer_id)->update(["is_default"=>0]);
            $server->setDefaultActive();
        }else{
            $server->setDefaultInactive();
        }
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 删除收货信息
     */
    public function deleteAddress($id=0)
    {
        $model = \App\Models\BuyerAddressModel::where("id",$id)->first();
        $server = new \App\Service\Api\BuyerAddressService($model);
        $server->setDelActive();
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 收货信息列表
     */
    public function getAddressList()
    {
        $query = \App\Models\BuyerAddressModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("del_status",\App\Models\BuyerAddressModel::delInactive);
        $total = $query->count();
        $result = $query->get();
        return \ResponseHelper::success([
            "total"=>$total,
            "list"=>$result,
        ]);
    }

    /**
     * @return mixed
     * 评价
     */
    public function postEvaluation()
    {
        $request = \Request::all();
        if (!isset($request["orders"])){
            return \ResponseHelper::error("评价失败",NULL,NULL,500);
        }
        \DB::beginTransaction();
        try{
            $id = 0;
            $arr = json_decode($request["orders"],true);
            //主订单编号
            $orderSn = "";
            foreach ($arr as $k => $v){
                $server = new \App\Service\Api\EvaluationService();
                $server->setContent($v['content']);
                $server->setImgUrl($v['img_url']);
                $orderSubModel = \App\Models\OrderSubModel::where("order_sub_sn",$v['order_sub_sn'])->first();
                $orderDetailModel = \App\Models\OrderDetailModel::where("order_sub_sn",$v['order_sub_sn'])->first();
                $orderSn = $orderSubModel->order_sn;
                $server->setOrderSub($orderSubModel);
                $server->setBuyer($this->curUser);
                $model = \App\Models\ProductModel::where("product_number",$v['product_number'])->first();
                $server->setProduct($model);
                $server->setSku($orderDetailModel);
                switch ($v['des_match']){
                    case "0":
                        $server->setBad();
                        break;
                    case "1":
                        $server->setNotGood();
                        break;
                    case "2":
                        $server->setGeneral();
                        break;
                    case "3":
                        $server->setGood();
                        break;
                    case "4":
                        $server->setPerfect();
                        break;
                }
                switch ($v['img_url']){
                    case "0":
                        $server->setNoImg();
                        break;
                    case "1":
                        $server->setHasImg();
                        break;
                }
                $model = $server->save();
                $id = $model->evaluation_id;

                $server = new \App\Service\Seller\OrderSubService($orderSubModel);
                $server->setIsEvaluation();
                $server->save();
            }
            $model = \App\Models\OrderModel::where("order_sn",$orderSn)->first();
            $server = new \App\Service\Seller\OrderService($model);
            $server->setIsEvaluation();
            $server->save();
            \DB::commit();

            if ($id){
                return \ResponseHelper::success(["id"=>$id]);
            }
        }catch (\Exception $e){
            \DB::rollBack();
            \Log::info($e);
            return \ResponseHelper::error("评价异常",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 补充用户信息
     */
    public function postSupplementUserInfo()
    {
        $request = \Request::all();
        $server = new \App\Service\Company\BuyerService($this->curUser);
        if (!$request["name"]){
            return \ResponseHelper::error("请填写用户真实姓名",NULL,NULL,500);
        }
        $model = \App\Models\CompanyModel::where("company_id",$request['company_id'])->first();
        if (!$model){
            return \ResponseHelper::error("企业信息异常",NULL,NULL,500);
        }
        $server->setName($request["name"]);
        $server->setCompany($model);
        $model = $server->save();
        if ($model){
            \BuyerSessionHelper::flush();
            return \ResponseHelper::success(["id"=>$model->buyer_id]);
        }else{
            return \ResponseHelper::error("补充用户信息失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 栗子
     */
    public function getMoneyDetail()
    {
        $list = \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id)
            ->orderBy("created_at","desc")
            ->take(5)
            ->get();
        $rWxMoney = \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->sum("wx_money");
        $rUserMoney= \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->sum("user_money");
        $cuserWxMoney= \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("status",\App\Models\MoneyLogModel::statusConsume)
            ->sum("wx_money");
        $cuserUserMoney= \App\Models\MoneyLogModel::where("buyer_id",$this->curUser->buyer_id)
            ->where("status",\App\Models\MoneyLogModel::statusConsume)
            ->sum("user_money");
        $consumTotal = $cuserWxMoney+$cuserUserMoney;
        $rechargeTotal = $rWxMoney+$rUserMoney;
        return \ResponseHelper::success([
            "consum_total"=>$consumTotal,
            "recharge_total"=>$rechargeTotal,
            "list"=>$list,
        ]);
    }
}
