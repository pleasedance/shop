<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 13:08
 */

namespace App\Http\Controllers\Seller\SellerAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class FareTemplateController extends BaseController
{
    /**
     * @return mixed
     * 商户运费模板详情页面
     */
    public function getFareTemplate($id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\FareTemplateModel::where("tpl_id",$id)
                ->with('carryMode')
                ->with('incPostageProviso')
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/faretemplate",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商户运费模板添加
     */
    public function postFareTemplate()
    {
        $request = \Request::all();
//        \Log::info($request);
//        return;
        $server = new \App\Service\Seller\FareTemplateService();
        try{
            DB::beginTransaction();
            $server->setTplName($request['tpl_name']);
            $server->setAddress($request['province'].$request['city'].$request['area']);
            $server->setSendTime(date('Y-m-d h:i:s',(time()+$request['send_time']*3600)));
            $server->setSellerId($request['seller_id']);
            if (isset($request['exemption_status'])){
                switch ($request['exemption_status']){
                    case 0:
                        $server->setIsExemption();
                        break;
                    case 1:
                        $server->setNoExemption();
                        break;
                }
            }

            if (isset($request['pricing_model_type'])){
                switch ($request['pricing_model_type']){
                    case 0:
                        $server->setNumberType();
                        break;
                    case 1:
                        $server->setWeightType();
                        break;
                    case 2:
                        $server->setVolumeType();
                        break;
                }
            }

            if (isset($request['requirement_status'])){
                $server->setIsRequirement();
            }else{
                $server->setNoRequirement();
            }

            $fareTemplateModel = $server->save();

            //运送方式
            if( isset($request['basics_price']) ){
                $count = count($request['basics_price']);
                $param = [];
                for ($i=0;$i<$count;$i++){
                    $param['area'] = !empty($request['areas'][$i])?$request['areas'][$i]:"默认";
                    $param['basics_number'] = !empty($request['basics_number'][$i])?$request['basics_number'][$i]:NULL;
                    $param['basics_weight'] = !empty($request['basics_weight'][$i])?$request['basics_weight'][$i]:NULL;
                    $param['basics_volume'] = !empty($request['basics_volume'][$i])?$request['basics_volume'][$i]:NULL;
                    $param['basics_price'] = !empty($request['basics_price'][$i])?$request['basics_price'][$i]:NULL;
                    $param['extra_weight'] = !empty($request['extra_weight'][$i])?$request['extra_weight'][$i]:NULL;
                    $param['extra_number'] = !empty($request['extra_number'][$i])?$request['extra_number'][$i]:NULL;
                    $param['extra_volume'] = !empty($request['extra_volume'][$i])?$request['extra_volume'][$i]:NULL;
                    $param['extra_price'] = !empty($request['extra_price'][$i])?$request['extra_price'][$i]:NULL;
                    $param['transfer_type'] = !empty($request['transfer_type'][$i])?$request['transfer_type'][$i]:NULL;
                    $server->setTransferType($fareTemplateModel,$param);
                }
            }
           

            if (isset($request['requirement_status'])){
                $count = count($request['incl_areas']);
                for ($i=0;$i<$count;$i++){
                    //包邮条件
                    $param['num'] = !empty($request['num'][$i])?$request['num'][$i]:NULL;
                    $param['weight'] = !empty($request['weight'][$i])?$request['weight'][$i]:NULL;
                    $param['volume'] = !empty($request['volume'][$i])?$request['volume'][$i]:NULL;
                    $param['money'] = !empty($request['money'][$i])?$request['money'][$i]:NULL;
                    $param['incl_areas'] = !empty($request['incl_areas'][$i])?$request['incl_areas'][$i]:NULL;
                    $server->setInclPostageProviso($fareTemplateModel,$param);
                }
            }
            DB::commit();
            return \ResponseHelper::success(["id"=>$fareTemplateModel->tpl_id]);
        }catch(\Exception $e){
            DB::rollBack();
            return \ResponseHelper::error("新增运费模板失败",NULL,NULL,500);
        }
//        if ($fareTemplateModel){
//            DB::commit();
//            return \ResponseHelper::success(["id"=>$fareTemplateModel->tpl_id]);
//        }else{
//            DB::rollBack();
//            return \ResponseHelper::error("新增运费模板失败",NULL,NULL,500);
//        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商户运费模板修改
     */
    public function putFareTemplate($id = 0)
    {
        $request = \Request::all();
//        \Log::info($request);
//        return;
        try{
            $model = \App\Models\FareTemplateModel::where("tpl_id",$id)->first();
            $server = new \App\Service\Seller\FareTemplateService($model);
            DB::beginTransaction();
            $server->setTplName($request['tpl_name']);
            $server->setAddress($request['province'].$request['city'].$request['area']);
            $server->setSendTime(date('Y-m-d h:i:s',(time()+$request['send_time']*3600)));
            $server->setSellerId($request['seller_id']);
            if (isset($request['exemption_status'])){
                switch ($request['exemption_status']){
                    case 0:
                        $server->setIsExemption();
                        break;
                    case 1:
                        $server->setNoExemption();
                        break;
                }
            }

            if (isset($request['pricing_model_type'])){
                switch ($request['pricing_model_type']){
                    case 0:
                        $server->setNumberType();
                        break;
                    case 1:
                        $server->setWeightType();
                        break;
                    case 2:
                        $server->setVolumeType();
                        break;
                }
            }

            if (isset($request['requirement_status'])){
                $server->setIsRequirement();
            }else{
                $server->setNoRequirement();
            }

            $fareTemplateModel = $server->save();

            \Log::info('运费模板'.$id."删除运送方式个数：".$model->carryMode()->delete());
            \Log::info('运费模板'.$id."删除包邮条件个数：".$model->incPostageProviso()->delete());
            //运送方式
            $count = count($request['basics_price']);
            $param = [];
            for ($i=0;$i<$count;$i++){
                $param['area'] = !empty($request['areas'][$i])?$request['areas'][$i]:"默认";
                $param['basics_number'] = !empty($request['basics_number'][$i])?$request['basics_number'][$i]:NULL;
                $param['basics_weight'] = !empty($request['basics_weight'][$i])?$request['basics_weight'][$i]:NULL;
                $param['basics_volume'] = !empty($request['basics_volume'][$i])?$request['basics_volume'][$i]:NULL;
                $param['basics_price'] = !empty($request['basics_price'][$i])?$request['basics_price'][$i]:NULL;
                $param['extra_weight'] = !empty($request['extra_weight'][$i])?$request['extra_weight'][$i]:NULL;
                $param['extra_number'] = !empty($request['extra_number'][$i])?$request['extra_number'][$i]:NULL;
                $param['extra_volume'] = !empty($request['extra_volume'][$i])?$request['extra_volume'][$i]:NULL;
                $param['extra_price'] = !empty($request['extra_price'][$i])?$request['extra_price'][$i]:NULL;
                $param['transfer_type'] = !empty($request['transfer_type'][$i])?$request['transfer_type'][$i]:NULL;
                $server->setTransferType($fareTemplateModel,$param);
            }

            if (isset($request['requirement_status'])){
                $count = count($request['incl_areas']);
                for ($i=0;$i<$count;$i++){
                    //包邮条件
                    $param['num'] = !empty($request['num'][$i])?$request['num'][$i]:NULL;
                    $param['weight'] = !empty($request['weight'][$i])?$request['weight'][$i]:NULL;
                    $param['volume'] = !empty($request['volume'][$i])?$request['volume'][$i]:NULL;
                    $param['money'] = !empty($request['money'][$i])?$request['money'][$i]:NULL;
                    $param['incl_areas'] = !empty($request['incl_areas'][$i])?$request['incl_areas'][$i]:NULL;
                    $server->setInclPostageProviso($fareTemplateModel,$param);
                }
            }
            DB::commit();
            return \ResponseHelper::success(["id"=>$fareTemplateModel->tpl_id]);
        }catch (\Exception $e){
            DB::rollBack();
            return \ResponseHelper::error("修改运费模板失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 商户运费模板列表
     */
    public function getFareTemplateList(){
        $res = [];
        $model = \App\Models\FareTemplateModel::where("seller_id",$this->curUser->seller_id)
            ->where("del_status",\App\Models\FareTemplateModel::delInactive)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/faretemplatelist",$res);
    }

    /**
     * @return string
     * @throws \App\Exceptions\AppException
     * 运送方式表单返回
     */
    public function postCarryMode(\Illuminate\Http\Request $request){
        $pricing_model_type = $request->input("pricing_model_type");
        if(is_null($pricing_model_type)){
            throw new \App\Exceptions\AppException("选择运送方式");
        }
        $str = "";
        switch ($pricing_model_type)
        {
            case 0:
                $str =  '<div class="panel panel-default">
                        <label class="input-inline">
                            <div class="panel-body">
                                默认运费<input type="text" name="basics_number[]" value="0" class="" style="width:3%">件内
                                <input type="text" name="basics_price[]" value="0" class="" style="width:3%">元，
                                每增加<input type="text" name="extra_number[]" value="0" class="" style="width:3%">件，
                                增加运费<input type="text" name="extra_price[]" value="0" class="" style="width:3%">元
                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a></div>
                            </div>
                        </label>
                    </div>';
                break;
            case 1:
                $str = '<div class="panel panel-default">
                        <div class="panel-body">
                            默认运费<input type="text" name="basics_weight[]" value="0" class="" style="width:3%">kg内
                            <input type="text" name="basics_price[]" value="0" class="" style="width:3%">元，
                            每增加<input type="text" name="extra_weight[]" value="0" class="" style="width:3%">kg，
                            增加运费<input type="text" name="extra_price[]" value="0" class="" style="width:3%">元
                            <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a></div>
                        </div>
                    </div>';
                break;
            case 2:
                $str = '<div class="panel panel-default">
                        <div class="panel-body">
                            默认运费<input type="text" name="basics_volume[]" value="0" class="" style="width:3%">m³内
                            <input type="text" name="basics_price[]" value="0" class="" style="width:3%">元，
                            每增加<input type="text" name="extra_volume[]" value="0" class="" style="width:3%">m³，
                            增加运费<input type="text" name="extra_price[]" value="0" class="" style="width:3%">元
                            <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a></div>
                        </div>
                    </div>';
        }

        return ['result'=>$str];
    }

    /**
     * @param $id
     * 运费模板禁用与启用
     */
    public function putFaretmpstat()
    {
        $request = \Request::all();
        $model = \App\Models\FareTemplateModel::where("tpl_id",$request['id'])->first();
        $server = new \App\Service\Seller\FareTemplateService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->tpl_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 运费模板删除
     */
    public function putDeltmp()
    {
        $request = \Request::all();
        $model = \App\Models\FareTemplateModel::where("tpl_id",$request['id'])->first();
        $server = new \App\Service\Seller\FareTemplateService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->tpl_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }
}