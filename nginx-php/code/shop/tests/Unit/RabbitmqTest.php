<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RabbitmqTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
//        $request = new \Request();
        $log = [
            'status' => \App\Models\MoneyLogModel::statusRecharge,
            'company_id' => 2,
            'buyer_id' => 0,
            'ip' => "192.168.0.105",
            'money' => 101,
            'remark' => '充值成功'
        ];
        //向队列推送数据
        $job = (new \App\Jobs\Queue($log))->onConnection('rabbitmq')->onQueue('test1');
        dispatch($job);

        $this->assertTrue(true);
    }
}
