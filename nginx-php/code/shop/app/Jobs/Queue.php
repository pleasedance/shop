<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Queue implements ShouldQueue
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
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info("消息队列启动----");
//        \Log::info($this->data);return;
        //用作处理消息队列内的数据
        try{
            $server = new \App\Service\Company\MoneyLogService();
            $server->setIp($this->data['ip']);
            if (isset($this->data['buyer'])){
                $server->setBuyer($this->data['buyer']);
            }
            if (isset($this->data['company'])){
                $server->setCompany($this->data['company']);
            }
            $server->setWxMoney($this->data['wx_money']);
            if (isset($this->data['user_money'])){
                $server->setUserMoney($this->data['user_money']);
            }
            if (isset($this->data['type'])){
                switch ($this->data['type']){
                    case 0:
                        $server->setCompanyRecharge();
                        break;
                    case 1:
                        $server->setUserRecharge();
                        break;
                    case 2:
                        $server->setCpToCpRecharge();
                        break;
                }
            }
            if (isset($this->data['order_sn'])){
                $server->setOrder($this->data['order_sn']);
            }
            $server->setRemark($this->data['remark']);
            if (isset($this->data['order_type'])){
                switch ($this->data['order_type']){
                    case "0":
                        $server->setOrderType();
                        break;
                    case "1":
                        $server->setOrderSubType();
                        break;
                    case "2":
                        $server->setOrderRecharge();
                        break;
                }
            }
            if ($this->data['status']){
                $server->setRecharge();
            }else{
                $server->setConsume();
            }
            $server->setPaySn($this->data['pay_sn']);
            $server->save();
            echo date("Y-m-d H:i:s")."成功";
        }catch(\Exception $e){
            //失败重回队列执行
//            self::dispatch((new \App\Jobs\Queue($this->data))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
            \Log::info("日志记录异常，原因：");
            \Log::info($e);
            echo date("Y-m-d H:i:s")."失败";
            throw $e;
        }
    }
}
