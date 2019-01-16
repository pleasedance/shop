<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/2
 * Time: 14:01
 */

namespace App\Models;


class EvaluationModel extends BaseModel
{
    protected $table = "pd_evaluation";
    protected $primaryKey = 'evaluation_id';

    const bad = 0;//非常差
    const notGood = 1;//差
    const general = 2;//一般
    const good = 3;//好
    const perfect = 4;//非常好

    const hasImg = 1;//是
    const noImg = 0;//否

    public function buyer(){
        return $this->hasOne("App\Models\BuyerModel","buyer_id","buyer_id");
    }

    public function reply(){
        return $this->hasOne("App\Models\EvaluationReplyModel","evaluation_id","evaluation_id");
    }

    public function sku(){
        return $this->hasOne("App\Models\SkuModel","sku_code","sku_code")->select(["property","sku_code"]);
    }
}