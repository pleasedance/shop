<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/14
 * Time: 11:30
 */

namespace App\Http\Controllers\Seller\SellerAdmin;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    /**
     * 选择分类
     */
    public function getCatalogProduct()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\CategoryModel::where("del_status",\App\Models\CategoryModel::delInactive)
            ->where("status",\App\Models\CategoryModel::statusActive)
            ->paginate(50);
        $res['list'] = $model;
        return \View::make("seller/admin/catalogproduct",$res);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商品添加
     */
    public function postProduct($id)
    {
        $request = \Request::all();
//        \Log::info($request);return;
        if(!$request['product_art_no']){
            throw new \App\Exceptions\AppException("请填写商品货号");
        }
        $productNumber = str_random(20);
        if(!$request["pd_name"]){
            throw new \App\Exceptions\AppException("请填写商品名称");
        }
        if(!$request["pd_subtitle"]){
            throw new \App\Exceptions\AppException("请填写商品副标题");
        }
        if(!$request["pd_descs"]){
            throw new \App\Exceptions\AppException("请填写商品介绍");
        }
        $pdBrandId = $request["brand_id"];//品牌ID
        if(!$request["express_tpl_id"]){
            throw new \App\Exceptions\AppException("请选择运费模版");
        }
        if(!$request["pd_unit"]){
            throw new \App\Exceptions\AppException("请填写商品计量单位");
        }
        if(!$request["pd_weight"]){
            throw new \App\Exceptions\AppException("请填写商品单位重量");
        }
        if(!$request["pd_weight_unit"]){
            throw new \App\Exceptions\AppException("请填写商品重量单位");
        }
        if(!$request["pd_volume"]){
            throw new \App\Exceptions\AppException("请填写商品单位体积");
        }
        if(!$request["pd_volume_unit"]){
            throw new \App\Exceptions\AppException("请填写商品体积单位");
        }
        if(!$request["detail_descr"]){
            throw new \App\Exceptions\AppException("请填写详情页描述");
        }
        if(!$request["pd_key_word"]){
            throw new \App\Exceptions\AppException("请填写商品关键词");
        }
        if(!$request["pd_remark"]){
            throw new \App\Exceptions\AppException("请填写商品备注");
        }
        if(!$request["pd_picture_prefix"]){
            throw new \App\Exceptions\AppException("请填写商品图片集合前缀");
        }
        if(!$request["pd_detail_info"]){
            throw new \App\Exceptions\AppException("请填写商品信息图文详情");
        }
        if(!$request["pd_sort"]){
            throw new \App\Exceptions\AppException("请填写排序");
        }
        if(!$request["detail_title"]){
            throw new \App\Exceptions\AppException("请填写详情页标题");
        }

        try{
            $server = new \App\Service\Seller\ProductService();
            DB::beginTransaction();
            $server->setProductArtNo($request['product_art_no']);
            $server->setProductNumber($productNumber);
            $server->setName($request["pd_name"]);
            $server->setSubtitle($request['pd_subtitle']);
            $server->setDescs($request['pd_descs']);
            $server->setCategoryId($request["pd_category_id"]);
            $server->setSellerId($request['seller_id']);
            $server->setBrandId($pdBrandId);
            $server->setExpressTplId($request['express_tpl_id']);
            $server->setMarketPrice($request['market_price']);
//            $server->setMemberPrice($request['member_price']);
            $server->setMinPrice($request['min_price']);
            $server->setUnit($request['pd_unit']);
            $server->setWeight($request['pd_weight']);
            $server->setWeightUnit($request['pd_weight_unit']);
            $server->setVolume($request['pd_volume']);
            $server->setVolumeUnit($request['pd_volume_unit']);
            if ($request['pd_is_sell']){
                $server->setIsSell();
            }else{
                $server->setNoSell();
            }
            $server->setRecommendType(bindec($request['pd_recommend_type']));
            $server->setServiceGuaranTee(bindec($request['pd_service_guarantee']));
            $server->setDetailDescr($request['detail_descr']);
            $server->setKeyWord($request['pd_key_word']);
            $server->setRemark($request['pd_remark']);
            $server->setPicturePrefix($request['pd_picture_prefix']);
            $server->setDetailInfo($request['pd_detail_info']);
            $server->setPdImageUrl($request['pd_image_url']);
            $server->setPdTranslationPic($request['pd_translation_pic']);
            $server->setSort($request['pd_sort']);
            if ($request['verify_status']){
                $server->setVerifyActive();
            }else{
                $server->setVerifyInactive();
            }
            //插入product数据
            $server->setDetailTitle($request['detail_title']);
            $productModel = $server->save();

            foreach ($request["sku_name"] as $k => $v){
                //插入属性
                $productSkuServer = new \App\Service\Seller\ProductSkuService();
                $productSkuServer->setName($k);
                $productSkuServer->setProductNumber($productNumber);
                $productSkuServer->setValue($v);
                $productSkuServer->save();
            }

            foreach ($request["pd_price"] as $k => $v){
//                $skuUniqueCode = str_random(20);
                //插入sku
                if (is_array($v)){
                    foreach ($v as $kk => $vv){
                        $skuUniqueCode = str_random(20);
                        $property = $kk.",";
                        $property .= $k.",";

                        $property = rtrim($property,",");
                        $skuServer = new \App\Service\Seller\SkuService();
                        $skuServer->setProductNumber($productNumber);
                        $skuServer->setProperty($property);
                        $skuServer->setSkuUniqueCode($skuUniqueCode);
                        $skuServer->setSkuCode($request["sku_number"][$k][$kk]);
                        $skuServer->save();

                        //插入库存数据
                        $skuPropertiesserver = new \App\Service\Seller\SkuPropertiesService();
                        $skuPropertiesserver->setPrice($request["pd_price"][$k][$kk]);
                        $skuPropertiesserver->setMemberPrice($request["member_price"][$k][$kk]);
                        $skuPropertiesserver->setStocks($request["pd_stocks"][$k][$kk]);
                        $skuPropertiesserver->setAlarmStocks($request["pd_alarm_stocks"][$k][$kk]);
                        $skuPropertiesserver->setSkuPictureUrl($request["pd_img"][$k][$kk]);
                        $skuPropertiesserver->setSkuUniqueCode($skuUniqueCode);
                        $skuPropertiesserver->setSkuCode($request["sku_number"][$k][$kk]);
                        $skuPropertiesserver->setProductNumber($productNumber);
                        $skuPropertiesserver->setVersion(1);
                        $skuPropertiesserver->save();
                    }
                }else{
                    $skuUniqueCode = str_random(20);
                    $property = $k.",";

                    $property = rtrim($property,",");
                    $skuServer = new \App\Service\Seller\SkuService();
                    $skuServer->setProductNumber($productNumber);
                    $skuServer->setProperty($property);
                    $skuServer->setSkuUniqueCode($skuUniqueCode);
                    $skuServer->setSkuCode($request["sku_number"][$k]);
                    $skuServer->save();

                    //插入库存数据
                    $skuPropertiesserver = new \App\Service\Seller\SkuPropertiesService();
                    $skuPropertiesserver->setPrice($request["pd_price"][$k]);
                    $skuPropertiesserver->setMemberPrice($request["member_price"][$k]);
                    $skuPropertiesserver->setStocks($request["pd_stocks"][$k]);
                    $skuPropertiesserver->setAlarmStocks($request["pd_alarm_stocks"][$k]);
                    $skuPropertiesserver->setSkuPictureUrl($request["pd_img"][$k]);
                    $skuPropertiesserver->setSkuUniqueCode($skuUniqueCode);
                    $skuPropertiesserver->setSkuCode($request["sku_number"][$k]);
                    $skuPropertiesserver->setProductNumber($productNumber);
                    $skuPropertiesserver->setVersion(1);
                    $skuPropertiesserver->save();
                }
            }
            DB::commit();
            return \ResponseHelper::success(["id"=>$productModel->product_id]);
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
            return \ResponseHelper::error("新增商品失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * @param string $productNumber
     * @return mixed
     * 商品详情页面
     */
    public function getProduct($id,$productNumber="")
    {
        $res = [];
        //用户信息
        $res['user'] = $this->curUser;
        //分类信息
        $res['category'] = \App\Models\CategoryModel::where("del_status",\App\Models\CategoryModel::delInactive)
            ->where("status",\App\Models\CategoryModel::statusActive)
            ->get();
        //分类参数相关信息
//        $res['categoryParam'] = \App\Models\CategoryParamModel::where("category_id",$id)
//            ->where("del_status",\App\Models\CategoryParamModel::delInactive)
//            ->where("status",\App\Models\CategoryParamModel::statusActive)
//            ->with('categoryProperties')
//            ->get();
        //属性相关信息
        $res['product_sku'] = \App\Models\ProductSkuModel::where("product_number",$productNumber)
            ->where("del_status",\App\Models\ProductSkuModel::delInactive)
            ->get();

        //运费模板ID
        $res['tpl'] = \App\Models\FareTemplateModel
            ::where("del_status",\App\Models\FareTemplateModel::delInactive)
            ->where("status",\App\Models\FareTemplateModel::statusActive)
            ->get();
        $res['brand'] = \App\Models\BrandModel
            ::where("del_status",\App\Models\BrandModel::delInactive)
            ->where("is_show",\App\Models\BrandModel::isShow)
            ->get();
        //分类ID
        $res['category_id'] = $id;
        //商品唯一code
        $res['product_number'] = $productNumber;
        //商品sku相关信息
        $res['sku'] = \App\Models\SkuModel::where("product_number",$productNumber)
            ->with('product')
            ->get();
        $res['sku_properties'] = \App\Models\SkuPropertiesModel::where("product_number",$productNumber)
            ->get();
        $res['sku_properties'] = $res['sku_properties']->toArray();
//        \Log::info($res['sku_properties']);return;
        //商品信息
        $res['model'] = (isset($res['sku'][0]))?$res['sku'][0]->product:NULL;
        return \View::make("seller/admin/product",$res);
    }

    /**
     * 商品修改
     */
    public function putProduct($id,$productNumber='')
    {
        $request = \Request::all();
//        \Log::info($request);return;
        if(!$request['product_art_no']){
            throw new \App\Exceptions\AppException("请填写商品货号");
        }
        if(!$request["pd_name"]){
            throw new \App\Exceptions\AppException("请填写商品名称");
        }
        if(!$request["pd_subtitle"]){
            throw new \App\Exceptions\AppException("请填写商品副标题");
        }
        if(!$request["pd_descs"]){
            throw new \App\Exceptions\AppException("请填写商品介绍");
        }
        $pdBrandId = $request["brand_id"];//品牌ID
        if(!$request["express_tpl_id"]){
            throw new \App\Exceptions\AppException("请选择运费模版");
        }
        if(!$request["pd_unit"]){
            throw new \App\Exceptions\AppException("请填写商品计量单位");
        }
        if(!$request["pd_weight"]){
            throw new \App\Exceptions\AppException("请填写商品单位重量");
        }
        if(!$request["pd_weight_unit"]){
            throw new \App\Exceptions\AppException("请填写商品重量单位");
        }
        if(!$request["pd_volume"]){
            throw new \App\Exceptions\AppException("请填写商品单位体积");
        }
        if(!$request["pd_volume_unit"]){
            throw new \App\Exceptions\AppException("请填写商品体积单位");
        }
        $pdRecommendType = 0;
        if(!$request["detail_descr"]){
            throw new \App\Exceptions\AppException("请填写详情页描述");
        }
        if(!$request["pd_key_word"]){
            throw new \App\Exceptions\AppException("请填写商品关键词");
        }
        if(!$request["pd_remark"]){
            throw new \App\Exceptions\AppException("请填写商品备注");
        }
        if(!$request["pd_picture_prefix"]){
            throw new \App\Exceptions\AppException("请填写商品图片集合前缀");
        }
        if(!$request["pd_detail_info"]){
            throw new \App\Exceptions\AppException("请填写商品信息图文详情");
        }
        if(!$request["pd_sort"]){
            throw new \App\Exceptions\AppException("请填写排序");
        }
        if(!$request["detail_title"]){
            throw new \App\Exceptions\AppException("请填写详情页标题");
        }

        try{
            //修改商品相关信息
            $product = \App\Models\ProductModel::where("product_number",$productNumber)
                ->first();
            $server = new \App\Service\Seller\ProductService($product);
            DB::beginTransaction();
            $server->setProductArtNo($request['product_art_no']);
            $server->setProductNumber($productNumber);
            $server->setName($request["pd_name"]);
            $server->setSubtitle($request['pd_subtitle']);
            $server->setDescs($request['pd_descs']);
            //修改分类取表单数据
            $server->setCategoryId($request["pd_category_id"]);
            $server->setSellerId($request['seller_id']);
            $server->setBrandId($pdBrandId);
            $server->setExpressTplId($request['express_tpl_id']);
            $server->setUnit($request['pd_unit']);
            $server->setWeight($request['pd_weight']);
            $server->setWeightUnit($request['pd_weight_unit']);
            $server->setMarketPrice($request['market_price']);
//            $server->setMemberPrice($request['member_price']);
            $server->setMinPrice($request['min_price']);
            $server->setVolume($request['pd_volume']);
            $server->setVolumeUnit($request['pd_volume_unit']);
            if ($request['pd_is_sell']){
                $server->setIsSell();
            }else{
                $server->setNoSell();
            }
            $server->setRecommendType(bindec($request['pd_recommend_type']));
            $server->setServiceGuaranTee(bindec($request['pd_service_guarantee']));
            $server->setDetailDescr($request['detail_descr']);
            $server->setKeyWord($request['pd_key_word']);
            $server->setRemark($request['pd_remark']);
            $server->setPicturePrefix($request['pd_picture_prefix']);
            $server->setDetailInfo($request['pd_detail_info']);
            $server->setPdImageUrl($request['pd_image_url']);
            $server->setPdTranslationPic($request['pd_translation_pic']);
            $server->setSort($request['pd_sort']);
            if ($request['verify_status']){
                $server->setVerifyActive();
            }else{
                $server->setVerifyInactive();
            }
            $server->setDetailTitle($request['detail_title']);
            $productModel = $server->save();

            //删除关联数据
            \Log::info("删除关联属性信息：".\App\Models\ProductSkuModel::where("product_number",$productNumber)
                    ->lockForUpdate()
                ->delete());
            \Log::info("删除sku信息：".\App\Models\SkuModel::where("product_number",$productNumber)
                    ->lockForUpdate()
                    ->delete());
            \Log::info("删除属性信息：".\App\Models\SkuPropertiesModel::where("product_number",$productNumber)
                    ->lockForUpdate()
                    ->delete());

            foreach ($request["sku_name"] as $k => $v){
                //插入属性
                $productSkuServer = new \App\Service\Seller\ProductSkuService();
                $productSkuServer->setName($k);
                $productSkuServer->setProductNumber($productNumber);
                $productSkuServer->setValue($v);
                $productSkuServer->save();
            }

            foreach ($request["pd_price"] as $k => $v){
//                $skuUniqueCode = str_random(20);
                //插入sku
                if (is_array($v)){
                    foreach ($v as $kk => $vv){
                        $skuUniqueCode = str_random(20);
                        $property = $kk.",";
                        $property .= $k.",";

                        $property = rtrim($property,",");
                        $skuServer = new \App\Service\Seller\SkuService();
                        $skuServer->setProductNumber($productNumber);
                        $skuServer->setProperty($property);
                        $skuServer->setSkuUniqueCode($skuUniqueCode);
                        $skuServer->setSkuCode($request["sku_number"][$k][$kk]);
                        $skuServer->save();

                        //插入库存数据
                        $skuPropertiesserver = new \App\Service\Seller\SkuPropertiesService();
                        $skuPropertiesserver->setPrice($request["pd_price"][$k][$kk]);
                        $skuPropertiesserver->setMemberPrice($request["member_price"][$k][$kk]);
                        $skuPropertiesserver->setStocks($request["pd_stocks"][$k][$kk]);
                        $skuPropertiesserver->setAlarmStocks($request["pd_alarm_stocks"][$k][$kk]);
                        $skuPropertiesserver->setSkuPictureUrl($request["pd_img"][$k][$kk]);
                        $skuPropertiesserver->setSkuUniqueCode($skuUniqueCode);
                        $skuPropertiesserver->setSkuCode($request["sku_number"][$k][$kk]);
                        $skuPropertiesserver->setProductNumber($productNumber);
                        $skuPropertiesserver->setVersion(1);
                        $skuPropertiesserver->save();
                    }
                }else{
                    $skuUniqueCode = str_random(20);
                    $property = $k.",";

                    $property = rtrim($property,",");
                    $skuServer = new \App\Service\Seller\SkuService();
                    $skuServer->setProductNumber($productNumber);
                    $skuServer->setProperty($property);
                    $skuServer->setSkuUniqueCode($skuUniqueCode);
                    $skuServer->setSkuCode($request["sku_number"][$k]);
                    $skuServer->save();

                    //插入库存数据
                    $skuPropertiesserver = new \App\Service\Seller\SkuPropertiesService();
                    $skuPropertiesserver->setPrice($request["pd_price"][$k]);
                    $skuPropertiesserver->setMemberPrice($request["member_price"][$k]);
                    $skuPropertiesserver->setStocks($request["pd_stocks"][$k]);
                    $skuPropertiesserver->setAlarmStocks($request["pd_alarm_stocks"][$k]);
                    $skuPropertiesserver->setSkuPictureUrl($request["pd_img"][$k]);
                    $skuPropertiesserver->setSkuUniqueCode($skuUniqueCode);
                    $skuPropertiesserver->setSkuCode($request["sku_number"][$k]);
                    $skuPropertiesserver->setProductNumber($productNumber);
                    $skuPropertiesserver->setVersion(1);
                    $skuPropertiesserver->save();
                }
            }
            DB::commit();
            return \ResponseHelper::success(["id"=>$productModel->product_id]);
        }catch (\Exception $e){
            DB::rollBack();
            \Log::info($e);
            return \ResponseHelper::error("修改商品失败",NULL,NULL,500);
        }
    }

    /**
     * 商品列表页面
     */
    public function getProductLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\ProductModel::where('del_status',\App\Models\ProductModel::delInactive)
            ->where("pd_seller_id",$this->curUser->seller_id)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/getproductlog",$res);
    }

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
        return \View::make("seller/admin/brand",$res);
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
        return \View::make("seller/admin/getbrandlog",$res);
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
     * @return mixed
     * 分类参数组详情页面
     */
    public function getCategoryParam($productNumber = "",$paramNumber = ""){
        $res = [];
        $res['user'] = $this->curUser;
        $res['product_number'] = $productNumber;
        if (!$productNumber){
            throw new \App\Exceptions\AppException("找不到该商品");
        }
//        $res['cmodel'] = \App\Models\CategoryModel::where("category_id",$cid)->first();

        if ($paramNumber){
            $model = \App\Models\CategoryParamModel::where("product_number",$productNumber)
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
    public function postCategoryParam($productNumber="")
    {
        $paramNumber = str_random(20);
        $model = \App\Models\ProductModel::where("product_number",$productNumber)->first();
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
        $server->setProduct($model);
        $server->setStatusActive();
        $server->setDelInactive();
        if ($isSearch){
            $server->setSearchActive();
        }else{
            $server->setSearchInactive();
        }

        $categoryParamModel = $server->save();
        if ($categoryParamModel){
            return \ResponseHelper::success(["id"=>$categoryParamModel->param_number]);
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
    public function putCategoryParam($productNumber = 0,$paramNumber = "")
    {
        $cmodel = \App\Models\ProductModel::where("product_number",$productNumber)->first();
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
        $server->setProduct($cmodel);
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
    public function getCateParamLog($paramNumber){
        $res = [];
        $model = \App\Models\CategoryParamModel::where("product_number",$paramNumber)
            ->where("del_status",\App\Models\CategoryParamModel::delInactive)
            ->paginate(10);
        $res['list'] = $model;
        $res['param_number'] = $paramNumber;
        return \View::make("seller/admin/cateparamlog",$res);
    }

    /**
     * @return mixed
     * 分类参数属性详情页面
     */
    public function getCategoryParamPro($paramNumber = "",$id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if (!$paramNumber){
            throw new \App\Exceptions\AppException("找不到该参数组");
        }
        $res['param_number'] = $paramNumber;

        $res['cmodel'] = \App\Models\CategoryParamModel::where("param_number",$paramNumber)
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
    public function postCategoryParamPro($paramNumber = "")
    {
        $paramPropertieValue = \Jinput::get("param_propertie_value");
        if(!$paramPropertieValue){
            throw new \App\Exceptions\AppException("请填写参数值");
        }
        $res['cmodel'] = \App\Models\CategoryParamModel::where("param_number",$paramNumber)
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
    public function putCategoryParamPro($paramNumber = "",$id = 0)
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
     * 删除商品
     */
    public function delProduct(){
        $request = \Request::all();
        $model = \App\Models\ProductModel::where("product_number",$request['product_number'])->first();
        $server = new \App\Service\Seller\ProductService($model);
        //删除关联数据
        \Log::info("删除关联属性信息：".\App\Models\ProductSkuModel::where("product_number",$request['product_number'])
                ->delete());
        \Log::info("删除sku信息：".\App\Models\SkuModel::where("product_number",$request['product_number'])
                ->delete());
        \Log::info("删除属性信息：".\App\Models\SkuPropertiesModel::where("product_number",$request['product_number'])
                ->delete());
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["product_id"=>$r->product_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }
}