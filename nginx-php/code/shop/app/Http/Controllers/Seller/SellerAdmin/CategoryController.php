<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/8
 * Time: 11:32
 */

namespace App\Http\Controllers\Seller\SellerAdmin;


class CategoryController extends BaseController
{
    /**
     * @return mixed
     * 分类详情页面
     */
    public function getCategory($id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\CategoryModel::where("category_id",$id)
                ->first();
            $res['model'] = $model;
            $res['p_category'] = \App\Models\CategoryModel::where("category_id","<>",$id)
                ->where("level","<",$res['model']->level)
                ->get();
        }else{
            $res['p_category'] = \App\Models\CategoryModel::get();
        }

        return \View::make("seller/admin/category",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类添加
     */
    public function postCategory()
    {
        $parentId = \Jinput::get("parent_id");
        $categoryName = \Jinput::get("category_name");
        if(!$categoryName){
            throw new \App\Exceptions\AppException("请填写分类名称");
        }
        $descr = \Jinput::get("descr");
        $pictureUrl = \Jinput::get("picture_url");
        $level = \Jinput::get("level");
        if(!$level){
            throw new \App\Exceptions\AppException("请填写分类级别");
        }
        $sort = \Jinput::get("sort");
        $unit = \Jinput::get("unit");
        $navigation_status = \Jinput::get("navigation_status");

        $server = new \App\Service\Seller\CategoryService();
        $server->setParentId($parentId);
        $server->setName($categoryName);
        $server->setDescr($descr);
        $server->setPictureUrl($pictureUrl);
        $server->setLevel($level);
        $server->setSort($sort);
        $server->setUnit($unit);
        $server->setStatusActive();
        $server->setDelInactive();
        if ($navigation_status){
            $server->setShowNavigation();
        }else{
            $server->setNoshowNavigation();
        }

        $categoryModel = $server->save();
        if ($categoryModel){
            return \ResponseHelper::success(["id"=>$categoryModel->category_id]);
        }else{
            return \ResponseHelper::error("新增分类失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类修改
     */
    public function putCategory($id = 0)
    {
        $parentId = \Jinput::get("parent_id");
        $categoryName = \Jinput::get("category_name");
        if(!$categoryName){
            throw new \App\Exceptions\AppException("请填写分类名称");
        }
        $descr = \Jinput::get("descr");
        $pictureUrl = \Jinput::get("picture_url");
        $level = \Jinput::get("level");
        if(!$level){
            throw new \App\Exceptions\AppException("请填写分类级别");
        }
        $sort = \Jinput::get("sort");
        $unit = \Jinput::get("unit");
        $navigation_status = \Jinput::get("navigation_status");
        $model = \App\Models\CategoryModel::where("category_id",$id)->first();

        $server = new \App\Service\Seller\CategoryService($model);
        $server->setParentId($parentId);
        $server->setName($categoryName);
        $server->setDescr($descr);
        $server->setPictureUrl($pictureUrl);
        $server->setLevel($level);
        $server->setSort($sort);
        $server->setUnit($unit);
        if ($navigation_status){
            $server->setShowNavigation();
        }else{
            $server->setNoshowNavigation();
        }
        $categoryModel = $server->save();
        if ($categoryModel){
            return \ResponseHelper::success(["id"=>$categoryModel->category_id]);
        }else{
            return \ResponseHelper::error("修改分类失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 分类列表页面
     */
    public function getCatalog(){
        $res = [];
        $model = \App\Models\CategoryModel::where("del_status",\App\Models\CategoryModel::delInactive)->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/catalog",$res);
    }

    /**
     * @return mixed
     * 分类参数组详情页面
     */
    public function getCategoryParam($cid = 0,$paramNumber = ""){
        $res = [];
        $res['user'] = $this->curUser;
        $res['category_id'] = $cid;
        if (!$cid){
            throw new \App\Exceptions\AppException("找不到该分类");
        }
        $res['cmodel'] = \App\Models\CategoryModel::where("category_id",$cid)->first();

        if ($paramNumber){
            $model = \App\Models\CategoryParamModel::where("category_id",$cid)
                ->where("param_number",$paramNumber)
                ->first();
            $res['model'] = $model;
        }

        return \View::make("seller/admin/categoryparam",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类参数组添加
     */
    public function postCategoryParam($cid=0)
    {
        $paramNumber = str_random(20);
        $model = \App\Models\CategoryModel::where("category_id",$cid)->first();
        $paramName = \Jinput::get("param_name");
        if(!$paramName){
            throw new \App\Exceptions\AppException("请填写参数组");
        }
        $isSearch = \Jinput::get("is_search");

        $sort = \Jinput::get("sort");

        $server = new \App\Service\Seller\CategoryParamService();
        $server->setParamNumber($paramNumber);
        $server->setParamName($paramName);
        $server->setSort($sort);
        $server->setCategory($model);
        $server->setStatusActive();
        $server->setDelInactive();
        if ($isSearch){
            $server->setSearchActive();
        }else{
            $server->setSearchInactive();
        }

        $categoryParamModel = $server->save();
        if ($categoryParamModel){
            return \ResponseHelper::success(["id"=>$categoryParamModel->param_id]);
        }else{
            return \ResponseHelper::error("新增分类参数失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类参数组修改
     */
    public function putCategoryParam($cid = 0,$paramNumber = "")
    {
        $cmodel = \App\Models\CategoryModel::where("category_id",$cid)->first();
        $paramName = \Jinput::get("param_name");
        if(!$paramName){
            throw new \App\Exceptions\AppException("请填写参数组");
        }
        $isSearch = \Jinput::get("is_search");

        $sort = \Jinput::get("sort");
        $model = \App\Models\CategoryParamModel::where("param_number",$paramNumber)->first();

        $server = new \App\Service\Seller\CategoryParamService($model);
        $server->setParamName($paramName);
        $server->setSort($sort);
        $server->setCategory($cmodel);
        $server->setStatusActive();
        $server->setDelInactive();
        if ($isSearch){
            $server->setSearchActive();
        }else{
            $server->setSearchInactive();
        }

        $categoryParamModel = $server->save();
        if ($categoryParamModel){
            return \ResponseHelper::success(["id"=>$categoryParamModel->param_id]);
        }else{
            return \ResponseHelper::error("修改分类参数失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 分类参数组列表页面
     */
    public function getCateParamLog($cid){
        $res = [];
        $model = \App\Models\CategoryParamModel::where("category_id",$cid)
            ->where("del_status",\App\Models\CategoryParamModel::delInactive)
            ->paginate(10);
        $res['list'] = $model;
        $res['category_id'] = $cid;
        return \View::make("seller/admin/cateparamlog",$res);
    }

    /**
     * @return mixed
     * 分类参数属性详情页面
     */
    public function getCategoryParamPro($cid = 0,$id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if (!$cid){
            throw new \App\Exceptions\AppException("找不到该参数组");
        }
        $res['param_id'] = $cid;

        $res['cmodel'] = \App\Models\CategoryParamModel::where("param_id",$cid)
            ->with("category")
            ->first();

        if ($id){
            $model = \App\Models\CategoryParamPropertiesModel::where("cpp_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/categoryparampro",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类参数属性添加
     */
    public function postCategoryParamPro($cid = 0)
    {
        $paramPropertieValue = \Jinput::get("param_propertie_value");
        if(!$paramPropertieValue){
            throw new \App\Exceptions\AppException("请填写参数值");
        }
        $res['cmodel'] = \App\Models\CategoryParamModel::where("param_id",$cid)
            ->with("category")
            ->first();

        $server = new \App\Service\Seller\CategoryParamPropertiesService();
        $server->setCategoryParamProperties($res['cmodel']);
        $server->setParamPropertieValue($paramPropertieValue);

        $categoryParamPropertiesModel = $server->save();
        if ($categoryParamPropertiesModel){
            return \ResponseHelper::success(["id"=>$categoryParamPropertiesModel->cpp_id]);
        }else{
            return \ResponseHelper::error("新增分类参数属性失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类参数属性修改
     */
    public function putCategoryParamPro($cid = 0,$id = 0)
    {
        $paramPropertieValue = \Jinput::get("param_propertie_value");
        if(!$paramPropertieValue){
            throw new \App\Exceptions\AppException("请填写参数值");
        }

        $model = \App\Models\CategoryParamPropertiesModel::where("cpp_id",$id)->first();

        $server = new \App\Service\Seller\CategoryParamPropertiesService($model);
        $server->setParamPropertieValue($paramPropertieValue);

        $categoryParamPropertiesModel = $server->save();
        if ($categoryParamPropertiesModel){
            return \ResponseHelper::success(["id"=>$categoryParamPropertiesModel->cpp_id]);
        }else{
            return \ResponseHelper::error("修改分类参数属性失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 分类参数属性列表页面
     */
    public function getCateParamLogPro($paramNumber){
        $res = [];
        $model = \App\Models\CategoryParamPropertiesModel::where("param_number",$paramNumber)->paginate(10);
        $res['list'] = $model;
        $res['param_number'] = $paramNumber;
        return \View::make("seller/admin/cateparamlogpro",$res);
    }

    /**
     * @return mixed
     * 分类sku详情页面
     */
    public function getCategorySku($cid = 0,$skuNumber = ""){
        $res = [];
        $res['user'] = $this->curUser;
        if (!$cid){
            throw new \App\Exceptions\AppException("找不到该分类");
        }
        $res['category_id'] = $cid;

        $res['cmodel'] = \App\Models\CategoryModel::where("category_id",$cid)
            ->first();

        if ($skuNumber){
            $model = \App\Models\CategorySkuModel::where("sku_number",$skuNumber)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/categorysku",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类sku添加
     */
    public function postCategorySku($cid = 0)
    {
        $skuNumber = str_random(20);
        $propertieName = \Jinput::get("propertie_name");
        if(!$propertieName){
            throw new \App\Exceptions\AppException("请填写属性组名称");
        }
        $isSearch = \Jinput::get("is_search");
        $isMultChoose = \Jinput::get("is_mult_choose");
        $sort = \Jinput::get("sort");
        $res['cmodel'] = \App\Models\CategoryModel::where("category_id",$cid)
            ->first();

        $server = new \App\Service\Seller\CategorySkuService();
        $server->setCategory($res['cmodel']);
        $server->setSkuNumber($skuNumber);
        $server->setPropertieName($propertieName);
        $server->setStatusActive();
        $server->setSort($sort);
        if ($isSearch){
            $server->setSearchActive();
        }else{
            $server->setSearchInactive();
        }

        if ($isMultChoose){
            $server->setMultChooseActive();
        }else{
            $server->setMultChooseInactive();
        }

        $categorySkuModel = $server->save();
        if ($categorySkuModel){
            return \ResponseHelper::success(["id"=>$categorySkuModel->propertie_id]);
        }else{
            return \ResponseHelper::error("新增分类sku失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类sku修改
     */
    public function putCategorySku($cid = 0,$skuNumber = "")
    {
        $propertieName = \Jinput::get("propertie_name");
        if(!$propertieName){
            throw new \App\Exceptions\AppException("请填写属性组名称");
        }
        $isSearch = \Jinput::get("is_search");
        $isMultChoose = \Jinput::get("is_mult_choose");
        $sort = \Jinput::get("sort");
        $res['cmodel'] = \App\Models\CategoryModel::where("category_id",$cid)
            ->first();
        $model = \App\Models\CategorySkuModel::where("sku_number",$skuNumber)
            ->first();

        $server = new \App\Service\Seller\CategorySkuService($model);
        $server->setCategory($res['cmodel']);
        $server->setPropertieName($propertieName);
        $server->setSort($sort);
        if ($isSearch){
            $server->setSearchActive();
        }else{
            $server->setSearchInactive();
        }

        if ($isMultChoose){
            $server->setMultChooseActive();
        }else{
            $server->setMultChooseInactive();
        }

        $categorySkuModel = $server->save();
        if ($categorySkuModel){
            return \ResponseHelper::success(["id"=>$categorySkuModel->propertie_id]);
        }else{
            return \ResponseHelper::error("修改分类sku失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 分类sku列表页面
     */
    public function getCategorySkuLog($id){
        $res = [];
        $model = \App\Models\CategorySkuModel::where("category_id",$id)
            ->where("del_status",\App\Models\CategorySkuModel::delInactive)
            ->paginate(10);
        $res['list'] = $model;
        $res['category_id'] = $id;
        return \View::make("seller/admin/categoryskulog",$res);
    }

    /**
     * @return mixed
     * 分类sku值详情页面
     */
    public function getCategorySkuProperties($cid = 0,$id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if (!$cid){
            throw new \App\Exceptions\AppException("找不到该分类");
        }
        $res['propertie_id'] = $cid;

        $res['cmodel'] = \App\Models\CategorySkuModel::where("propertie_id",$cid)
            ->with("category")
            ->first();

        if ($id){
            $model = \App\Models\CategorySkuPropertiesModel::where("sp_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/categoryskuproperties",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类sku值添加
     */
    public function postCategorySkuProperties($skuNumber = "")
    {
        $skuPropertieValue = \Jinput::get("sku_propertie_value");
        if(!$skuPropertieValue){
            throw new \App\Exceptions\AppException("请填写分类sku值");
        }

        $res['cmodel'] = \App\Models\CategorySkuModel::where("sku_number",$skuNumber)
            ->with("category")
            ->first();

        $server = new \App\Service\Seller\CategorySkuPropertiesService();
        $server->setCategory($res['cmodel']);
        $server->setSkuPropertieValue($skuPropertieValue);

        $categorySkuPropertiesModel = $server->save();
        if ($categorySkuPropertiesModel){
            return \ResponseHelper::success(["id"=>$categorySkuPropertiesModel->sp_id]);
        }else{
            return \ResponseHelper::error("新增分类sku值失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 分类sku值修改
     */
    public function putCategorySkuProperties($skuNumber = "",$id = 0)
    {
        $skuPropertieValue = \Jinput::get("sku_propertie_value");
        if(!$skuPropertieValue){
            throw new \App\Exceptions\AppException("请填写分类sku值");
        }
        $model = \App\Models\CategorySkuPropertiesModel::where("sp_id",$id)
            ->first();

        $server = new \App\Service\Seller\CategorySkuPropertiesService($model);
        $server->setSkuPropertieValue($skuPropertieValue);

        $categorySkuPropertiesModel = $server->save();
        if ($categorySkuPropertiesModel){
            return \ResponseHelper::success(["id"=>$categorySkuPropertiesModel->sp_id]);
        }else{
            return \ResponseHelper::error("修改分类sku值失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 分类sku值列表页面
     */
    public function getCategorySkuPropertiesLog($skuNumber){
        $res = [];
        $model = \App\Models\CategorySkuPropertiesModel::where("sku_number",$skuNumber)->paginate(10);
        $res['list'] = $model;
        $res['sku_number'] = $skuNumber;
        return \View::make("seller/admin/categoryskupropertieslog",$res);
    }

    /**
     * @param $id
     * 分类禁用与启用
     */
    public function putCategoryStat()
    {
        $request = \Request::all();
        $model = \App\Models\CategoryModel::where("category_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategoryService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->category_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类删除
     */
    public function putCategoryDel()
    {
        $request = \Request::all();
        $model = \App\Models\CategoryModel::where("category_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategoryService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->category_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类参数禁用与启用
     */
    public function putCategoryParamStat()
    {
        $request = \Request::all();
        $model = \App\Models\CategoryParamModel::where("param_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategoryParamService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->param_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类参数删除
     */
    public function putCategoryParamDel()
    {
        $request = \Request::all();
        $model = \App\Models\CategoryParamModel::where("param_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategoryParamService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->param_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类Sku禁用与启用
     */
    public function putCategorySkuStat()
    {
        $request = \Request::all();
        $model = \App\Models\CategorySkuModel::where("propertie_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategorySkuService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->param_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类Sku删除
     */
    public function putCategorySkuDel()
    {
        $request = \Request::all();
        $model = \App\Models\CategorySkuModel::where("propertie_id",$request['id'])->first();
        $server = new \App\Service\Seller\CategorySkuService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->propertie_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }
}