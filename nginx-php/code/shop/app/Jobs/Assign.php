<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
/**
 * Description of Assign
 *
 * @author Administrator
 */
class Assign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    
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
        $model= $this->data['model'];
        $history=\App\Models\CompanyAssignModel::where("company_id",$model->company_id)->where("status", \App\Models\CompanyAssignModel::statusSuccess)->get();
        $notBetween=[];
        if($history->toArray()){
            foreach ($history as $value){
                if($value->between){
                    $notBetween[]=$value->between;
                }
            }
        }
        $successNum=0;
        $num = $model->num;
        $firstId=NULL;
        $lastId=NULL;
        $assignUids=[];
        $server=new \App\Service\Company\AssignService($model);
        $runTime=date("Y-m-d H:i:s");
        $_num=min([($num-$successNum),1000]);
        try {
            while (TRUE){
                $query=\App\Models\UserModel::where("created_at","<=",$runTime)->orderBy("id","desc")->take($_num);
                if($notBetween){
                    foreach ($notBetween as $value){
                        $query->whereNotBetween("id",$value);
                    }
                }
                if($assignUids){
                    $query=$query->whereNotIn("id",$assignUids);
                }
                $result=$query->get();
                $list=[];
                if(!$result->toArray()){
                    break;
                }
                foreach ($result as $value){
                    if(!$firstId){
                        $firstId=$value->id;
                    }
                    $lastId=$value->id;
                    $assignUids[]=$value->id;
                    $list[]=[
                        "user_id"=>$value->id,
                        "realname"=>$value->realname,
                        "mobile"=>$value->mobile,
                        "id_card"=>$value->id_card,
                        "brank"=>$value->brank,
                    ];
                }
                $ret=$this->fp($list,$model->company_id);
                foreach ($ret as $id=>$value){
                    if($value){
                        $successNum++;
                    }
                }
                $_num=min([($num-$successNum),1000]);
                $server->successNum($successNum);
            }
            $server->success($firstId, $lastId);
        } catch (\Exception $exc) {
            if($successNum){
                $server->success($firstId, $lastId);
            }else{
                $server->fail($exc->getMessage());
            }
        }

    }
    
    
    public function fp($userlist=[],$companyId){
        $api=new \CompanySdk\CustomManager();
        $api->setParam(["customs"=>$userlist,"company_id"=>$companyId]);
        $result=$api->run();
        return $result;
    }
}
