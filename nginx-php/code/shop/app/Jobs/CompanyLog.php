<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CompanyLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    public $timeout = 30;

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
        $server = new \App\Service\Company\CompanyMoneyLogService();
        $server->setIp();
        $server->setComany($this->data['company']);
        $server->setMoney($this->data['money']);
        $server->setRemark($this->data['remark']);
        $moneyLog = $server->save();
        if ($moneyLog){
            echo date("Y-m-d H:i:s")."成功";
        }else{
            echo date("Y-m-d H:i:s")."失败";
        }
    }
}
