<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderPre implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    public $timeout = 30;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sumProductMoney = 0;
//        $sumPaymentMoney = 0;
//        $sumDiscountMoney = 0;
//        $sumActivityMoney = 0;
        $invoiceNumber = str_random(16);
        \DB::beginTransaction();
        //获取收货地址model
        $buyerAddressmodel = \App\Models\BuyerAddressModel::where("id",$this->data["buyer_address_id"])->first();
        //创建总订单model
        $orderServer = new \App\Service\Seller\OrderService();
        try{
            foreach ($this->data['products'] as $v){
                $orderSubSn = str_random(24);//子订单号
                $skuPropertiesModel = \App\Models\SkuPropertiesModel::where("sku_unique_code",$v["sku_unique_code"])->first();
                //计算商品总价
                $sumProductMoney += $skuPropertiesModel->pd_price;
                //若库存不够，返回失败
                if ($skuPropertiesModel->pd_stocks < $v["cnt"]){
                    return \ResponseHelper::error("库存不足",NULL,NULL,500);
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
                $server->setBuyer($this->data["user"]);
                $server->setOrderSn($this->data["order_sn"]);
                $server->setProductMoney($v['product_money']);
                switch ($v["payment_method"]){
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

                $server->buyerAddress($buyerAddressmodel);
                if (!empty($this->data["coupon_id"])){
                    $model = \App\Models\CoupanModel::where("coupon_id",$this->data["coupon_id"])->first();
                    $server->setCoupan($model);
                }
                if (!empty($this->data["activity_id"])){
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
                $server->setOrderSn($this->data["order_sn"]);
                $productModel = \App\Models\ProductModel::where("product_number",$v["product_number"])->first();
                $server->setProduct($productModel);
                $server->setCnt($v["cnt"]);
                $server->setMoney($v['product_money']);
//                $server->setDiscountMoney($v['discount_money']);
//                $server->setDetailGrowth();
//                $server->setDetailLeGlod();
                $server->setSkuUniqueCode($skuPropertiesModel);
                $skuModel = \App\Models\SkuModel::where("sku_unique_code",$v["sku_unique_code"])->first();
                $server->setProductSku($skuModel);
                $server->save();
            }

            //初始化总订单model
            $orderServer->setOrderSn($this->data["order_sn"]);
            $orderServer->setBuyer($this->data["user"]);
            $orderServer->setBuyerAddress($buyerAddressmodel);
            $orderServer->setProductMoney($sumProductMoney);
            $orderServer->save();
            \DB::commit();
            //将支付超时任务丢入任务中心,设置消费时间
            $task["order_sn"] = $this->data["order_sn"];
            \App\Jobs\PayJob::dispatch($task)->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE"))->delay(Carbon::now()->addMinutes(30));
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
            DB::rollBack();
            throw $e;
        }
    }
}
