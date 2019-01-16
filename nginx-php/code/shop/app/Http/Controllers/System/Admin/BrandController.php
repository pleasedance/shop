<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 18:03
 */

namespace App\Http\Controllers\System\Admin;


class BrandController extends BaseController
{
    /**
     * 品牌添加
     */
    public function postBrand()
    {
        $request = \Request::all();
        if(!$request['brand_name']){
            throw new \App\Exceptions\AppException("请填写品牌名称");
        }
        if(!$request["brand_initials"]){
            throw new \App\Exceptions\AppException("请填写品牌首字母");
        }

        $server = new \App\Service\Seller\BrandService();
        $server->setBrandName($request['brand_name']);
        $server->setBrandInitials($request['brand_initials']);
        if ($request['brand_logo_url']){
            $server->setBrandLogoUrl($request["brand_logo_url"]);
        }
        if ($request['brand_detail_url']){
            $server->setBrandDetailUrl($request["brand_detail_url"]);
        }
        if ($request['brand_introduce']){
            $server->setBrandIntroduce($request["brand_introduce"]);
        }
        if ($request['sort']){
            $server->setSort($request["sort"]);
        }

        if ($request['is_show']){
            $server->setIsShow();
        }else{
            $server->setNoShow();
        }
        $brandModel = $server->save();
        if ($brandModel){
            return \ResponseHelper::success(["id"=>$brandModel->brand_id]);
        }else{
            return \ResponseHelper::error("新增品牌失败",NULL,NULL,500);
        }
    }

    /**
     * 品牌详情页面
     */
    public function getBrand($id=0)
    {
        $res = [];
        //用户信息
        $res['user'] = $this->curUser;
        $model = \App\Models\BrandModel::where("brand_id",$id)->first();
        $res['model'] = $model;
        return \View::make("system/admin/brand",$res);
    }

    /**
     * 品牌修改
     */
    public function putBrand($id=0)
    {
        $request = \Request::all();
        if(!$request['brand_name']){
            throw new \App\Exceptions\AppException("请填写品牌名称");
        }
        if(!$request["brand_initials"]){
            throw new \App\Exceptions\AppException("请填写品牌首字母");
        }

        $model = \App\Models\BrandModel::where("brand_id",$id)->first();
        $server = new \App\Service\Seller\BrandService($model);
        $server->setBrandName($request['brand_name']);
        $server->setBrandInitials($request['brand_initials']);
        if ($request['brand_logo_url']){
            $server->setBrandLogoUrl($request["brand_logo_url"]);
        }
        if ($request['brand_detail_url']){
            $server->setBrandDetailUrl($request["brand_detail_url"]);
        }
        if ($request['brand_introduce']){
            $server->setBrandIntroduce($request["brand_introduce"]);
        }
        if ($request['sort']){
            $server->setSort($request["sort"]);
        }

        if ($request['is_show']){
            $server->setIsShow();
        }else{
            $server->setNoShow();
        }
        $brandModel = $server->save();
        if ($brandModel){
            return \ResponseHelper::success(["id"=>$brandModel->brand_id]);
        }else{
            return \ResponseHelper::error("修改品牌失败",NULL,NULL,500);
        }
    }

    /**
     * 品牌列表页面
     */
    public function getBrandLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\BrandModel::where("del_status",\App\Models\BrandModel::delInactive)->paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/getbrandlog",$res);
    }

    /**
     * @param $id
     * 分类禁用与启用
     */
    public function putBrandStat()
    {
        $request = \Request::all();
        $model = \App\Models\BrandModel::where("brand_id",$request['id'])->first();
        $server = new \App\Service\Seller\BrandService($model);
        if ($request['todo']){
            $server->setIsShow();
        }else{
            $server->setNoShow();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->brand_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类删除
     */
    public function putBrandDel()
    {
        $request = \Request::all();
        $model = \App\Models\BrandModel::where("brand_id",$request['id'])->first();
        $server = new \App\Service\Seller\BrandService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->brand_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }

    /**
     * 广告列表
     */
    public function getAdvertisements()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\AdvertisementModel::where("del_status",\App\Models\AdvertisementModel::delInactive)->paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/advertisements",$res);
    }

    /**
     * 广告详情
     */
    public function getAdvertisement($id=0)
    {
        $res = [];
        //用户信息
        $res['user'] = $this->curUser;
        $model = \App\Models\AdvertisementModel::where("ad_id",$id)->first();
        $res['model'] = $model;
        return \View::make("system/admin/advertisement",$res);
    }

    /**
     * 广告添加
     */
    public function postAdvertisement()
    {
        $request = \Request::all();
//        \Log::info($request);return;
        if(!$request['ad_name']){
            throw new \App\Exceptions\AppException("请填写广告名称");
        }

        $server = new \App\Service\System\AdvertisementService();
        $server->setName($request['ad_name']);
        switch ($request["ad_position"]){
            case "0":
                $server->setXiaochengxu();
                break;
        }
        $server->setAdPicture(rtrim($request['ad_picture'],","));
        switch ($request['start']){
            case "0":
                $server->setNoStart();
                break;
            case "1":
                $server->setStart();
                break;
        }
        switch ($request['type']){
            case "0":
                $server->setTypexiaochengxu();
                break;
            case "1":
                $server->setTypeNotxiaochengxu();
                break;
        }
        $server->setAdUrl($request['ad_url']);
        $server->setRemarks($request['remarks']);
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->ad_id]);
        }else{
            return \ResponseHelper::error("新增广告失败",NULL,NULL,500);
        }
    }

    /**
     * 广告修改
     */
    public function putAdvertisement($id=0)
    {
        $request = \Request::all();
        if(!$request['ad_name']){
            throw new \App\Exceptions\AppException("请填写广告名称");
        }

        $model = \App\Models\AdvertisementModel::where("ad_id",$id)->first();
        $server = new \App\Service\System\AdvertisementService($model);
        $server->setName($request['ad_name']);
        switch ($request["ad_position"]){
            case "0":
                $server->setXiaochengxu();
                break;
        }
        $server->setAdPicture(rtrim($request['ad_picture'],","));
        switch ($request['start']){
            case "0":
                $server->setNoStart();
                break;
            case "1":
                $server->setStart();
                break;
        }
        switch ($request['type']){
            case "0":
                $server->setTypexiaochengxu();
                break;
            case "1":
                $server->setTypeNotxiaochengxu();
                break;
        }
        $server->setAdUrl($request['ad_url']);
        $server->setRemarks($request['remarks']);
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success(["id"=>$model->ad_id]);
        }else{
            return \ResponseHelper::error("修改广告失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 广告删除
     */
    public function putAdvertisementDel()
    {
        $request = \Request::all();
        $model = \App\Models\AdvertisementModel::where("ad_id",$request['id'])->first();
        $server = new \App\Service\System\AdvertisementService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->ad_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }
}