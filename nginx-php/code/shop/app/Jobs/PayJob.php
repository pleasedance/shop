<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PayJob implements ShouldQueue
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
     * 超时未支付
     * @return void
     */
    public function handle()
    {
        \DB::beginTransaction();
        try{
            \Log::info("超时未支付队列执行开始");
            \Log::info("总订单编号：".$this->data["order_sn"]);
            $skuCodes = [];
            //查找该总订单,子订单，订单详情
            $model = \App\Models\OrderModel::where("order_sn",$this->data["order_sn"])->first();
            $orderServer = new \App\Service\Seller\OrderService($model);
            $subModel = \App\Models\OrderSubModel::where("order_sn",$this->data["order_sn"])->get();
            $detailModel = \App\Models\OrderDetailModel::where("order_sn",$this->data["order_sn"])->get();
            if ($model->pay_status == \App\Models\OrderModel::statusNoPay){
                //修改总订单状态为失效
                $orderServer->setStatusInactive();
                $orderServer->save();

                foreach ($subModel as $k => $v){
                    //修改子订单状态为失效
                    $orderSubServer = new \App\Service\Seller\OrderSubService($v);
                    $orderSubServer->setStatusInactive();
                    $orderSubServer->save();
                    //将sku唯一code放入数组
                    $skuCodes[$detailModel[$k]->sku_code] = $detailModel[$k]->product_cnt;//键sku唯一code放入数组，值购买数量
                }

                //回滚库存
                foreach ($skuCodes as $k => $v){
                    //若不支付或支付超时，pd_frozen_stocks减N,pd_stocks加N
                    $model = \App\Models\SkuPropertiesModel::where("sku_code",$k)->first();
                    $server = new \App\Service\Seller\SkuPropertiesService($model);
                    $server->setStocks($model->pd_stocks+$v);
                    $server->setFrozenStocks($model->pd_frozen_stocks-$v);
                    $server->save();
                }
                \DB::commit();
                \Log::info("超时未支付,状态已修改");
            }
            \Log::info("超时未支付队列执行完毕");
            echo date("Y-m-d H:i:s")."成功";
        }catch(\Exception $e){
            \DB::rollBack();
            \Log::info("超时未支付异常-----");
            \Log::info($e);
//            self::dispatch($this->data)->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE_PAY_TIME"))->delay(\Carbon\Carbon::now()->addMinutes(30));
//            \Log::info("超时未支付异常-----丢回队列重新执行");
            echo date("Y-m-d H:i:s")."失败";
            throw $e;
        }
    }
}
