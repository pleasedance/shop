<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 13:39
 */

namespace App\Http\Controllers\Seller\SellerAdmin;


class SellerConfigController extends BaseController
{
    /**
     * @return mixed
     * 商户配置详情页面
     */
    public function getSellerConfig($id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\SellerConfigModel::where("config_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/sellerconfig",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商户添加配置
     */
    public function postSellerConfig()
    {
        $configItem = \Jinput::get("config_item");
        if(!$configItem){
            throw new \App\Exceptions\AppException("请填写配置项名称");
        }
        $configValue = \Jinput::get("config_value");
        if(!$configValue){
            throw new \App\Exceptions\AppException("请填写配置项value");
        }
        $sort = \Jinput::get("sort");
        if(!$sort){
            throw new \App\Exceptions\AppException("请填写排序设置");
        }
        $remark = \Jinput::get("remark");
        $seller_id = \Jinput::get("seller_id");

        $server = new \App\Service\Seller\SellerConfigService();
        $server->setSellerId($seller_id);
        $server->setConfigItem($configItem);
        $server->setConfigValue($configValue);
        $server->setSort($sort);
        $server->setRemark($remark);
        $sellerConfigModel = $server->save();
        if ($sellerConfigModel){
            return \ResponseHelper::success(["id"=>$sellerConfigModel->id]);
        }else{
            return \ResponseHelper::error("新增商家配置失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商户修改配置
     */
    public function putSellerConfig($id = 0)
    {
        $configItem = \Jinput::get("config_item");
        if(!$configItem){
            throw new \App\Exceptions\AppException("请填写配置项名称");
        }
        $configValue = \Jinput::get("config_value");
        if(!$configValue){
            throw new \App\Exceptions\AppException("请填写配置项value");
        }
        $sort = \Jinput::get("sort");
        if(!$sort){
            throw new \App\Exceptions\AppException("请填写排序设置");
        }
        $remark = \Jinput::get("remark");
        $model = \App\Models\SellerConfigModel::where("config_id",$id)->first();
        
        $server = new \App\Service\Seller\SellerConfigService($model);
        $server->setConfigItem($configItem);
        $server->setConfigValue($configValue);
        $server->setSort($sort);
        $server->setRemark($remark);
        $sellerConfigModel = $server->save();
        if ($sellerConfigModel){
            return \ResponseHelper::success(["id"=>$sellerConfigModel->config_id]);
        }else{
            return \ResponseHelper::error("新增商家配置失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 商户配置列表页面
     */
    public function getSellerConfigList(){
        $res = [];
        $model = \App\Models\SellerConfigModel::where("seller_id",$this->curUser->seller_id)
//            ->where('del_status',\App\Models\SellerConfigModel::delInactive)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/sellerconfiglist",$res);
    }
    /**
     * @return mixed
     * 删除配置
     */
    public function delSellerConfig()
    {
        $request = \Request::all();
        $model = \App\Models\SellerConfigModel::where("config_id",$request['config_id'])->first();
        $server = new \App\Service\Seller\SellerConfigService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["config_id"=>$r->config_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }
}