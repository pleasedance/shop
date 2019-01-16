<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 2.3.1
Version: 1.3
Author: KeenThemes
Website: http://www.keenthemes.com/preview/?theme=metronic
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469
-->
<!--[if IE 8]> <html lang="zh-CN" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh-CN" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="zh-CN" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php echo View::make('common/header'); ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/resource/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    {!! we_css() !!}
    {!! we_js() !!}
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN HEADER -->
<?php echo View::make('common/top'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<style type="text/css">
   *{
    list-style: none;
   }
   #ul_pics li{
    float: left !important;
    margin-left: 10px;
    margin-top: 10px;
   }
</style>
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php echo View::make('common/menu', ["code" => "product"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 商品管理
                <small><?php echo isset($model) ? "修改" : "添加"; ?>商品</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/selleradmin">商家管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">商品管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/selleradmin/product/<?php echo $category_id; ?>/<?php echo ($product_number)?$product_number:"";?>" method="<?php echo isset($model) ? "put" : "post"; ?>">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#detail" data-toggle="tab">
                                            基本信息
                                        </a>
                                    </li>
                                    <li><a href="#sku" data-toggle="tab">商品库存</a></li>
                                </ul>
                                    <div class="form-body tab-content">
                                        <div class="tab-pane fade in active" id="detail">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品货号
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="product_art_no" value="<?php echo isset($model) ? $model->product_art_no : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品名称
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_name" value="<?php echo isset($model) ? $model->pd_name : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品副标题
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_subtitle" value="<?php echo isset($model) ? $model->pd_subtitle : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品介绍
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" name="pd_descs"><?php echo isset($model) ? $model->pd_descs : ""; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    运费模板
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="express_tpl_id" class="form-control input-inline input-medium" id="express_tpl_id">
                                                        <option value="0">未选择运费模板</option>
                                                        <?php
                                                        foreach ($tpl as $v){
                                                            echo "<option value='{$v->tpl_id}' ".((isset($model->express_tpl_id)&&($model->express_tpl_id==$v->tpl_id))?'selected':'').">{$v->tpl_name}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    分类
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="pd_category_id" class="form-control input-inline input-medium">
                                                        <option value="0">未选择分类</option>
                                                        <?php
                                                        foreach ($category as $v){
                                                            echo "<option value='{$v->category_id}' ".((isset($model->pd_category_id)&&($model->pd_category_id==$v->category_id))?'selected':'').">{$v->name}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    品牌
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="brand_id" class="form-control input-inline input-medium">
                                                        <option value="0">未选择品牌</option>
                                                        <?php
                                                        foreach ($brand as $v){
                                                            echo "<option value='{$v->brand_id}' ".((isset($model->pd_brand_id)&&($model->pd_brand_id==$v->brand_id))?'selected':'').">{$v->brand_name}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品计量单位
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_unit" value="<?php echo isset($model) ? $model->pd_unit : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品单位重量
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_weight" value="<?php echo isset($model) ? $model->pd_weight : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品重量单位
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_weight_unit" value="<?php echo isset($model) ? $model->pd_weight_unit : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品单位体积
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_volume" value="<?php echo isset($model) ? $model->pd_volume : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品体积单位
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_volume_unit" value="<?php echo isset($model) ? $model->pd_volume_unit : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    推荐
                                                    <span class="required" aria-required="true">  </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <?php
                                                    $pd_recommend_type = isset($model)?decbin($model->pd_recommend_type):"";
                                                    $tmp = "";
                                                    if(strlen($pd_recommend_type)<4){
                                                        for ($i=0;$i<(4-strlen($pd_recommend_type));$i++){
                                                            $tmp .= "0";
                                                        }
                                                    }
                                                    $pd_recommend_type = $tmp.$pd_recommend_type;
                                                    ?>
                                                    <input type="checkbox" name="recommend_type" value="精选培训" class="form-control input-inline" <?php echo ($pd_recommend_type[1]) ? "checked" : "";?> >精选培训
                                                    <input type="checkbox" name="recommend_type" value="精品套餐" class="form-control input-inline" <?php echo ($pd_recommend_type[2]) ? "checked" : "";?> >精品套餐
                                                    <input type="checkbox" name="recommend_type" value="人气推荐" class="form-control input-inline" <?php echo ($pd_recommend_type[3]) ? "checked" : "";?> >人气推荐
                                                    <input type="hidden" name="pd_recommend_type" value="<?php echo $pd_recommend_type;?>" class="form-control input-inline" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    是否上架
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="radio" name="pd_is_sell" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->pd_is_sell) ? "checked" : "";?> >是
                                                    <input type="radio" name="pd_is_sell" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->pd_is_sell) ? "checked" : "";?> >否
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    服务保证
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <?php
                                                    $pd_service_guarantee = isset($model)?decbin($model->pd_service_guarantee):"";
                                                    $tmp = "";
                                                    if(strlen($pd_service_guarantee)<4){
                                                        for ($i=0;$i<(4-strlen($pd_service_guarantee));$i++){
                                                            $tmp .= "0";
                                                        }
                                                    }
                                                    $pd_service_guarantee = $tmp.$pd_service_guarantee;
                                                    ?>
                                                    <input type="checkbox" name="service_guarantee" value="无忧退货" class="form-control input-inline" <?php echo ($pd_service_guarantee[1]) ? "checked" : "";?> >无忧退货
                                                    <input type="checkbox" name="service_guarantee" value="快速退款" class="form-control input-inline" <?php echo ($pd_service_guarantee[2]) ? "checked" : "";?> >快速退款
                                                    <input type="checkbox" name="service_guarantee" value="免费包邮" class="form-control input-inline" <?php echo ($pd_service_guarantee[3]) ? "checked" : "";?>>免费包邮
                                                    <input type="hidden" name="pd_service_guarantee" value="<?php echo $pd_service_guarantee;?>" class="form-control input-inline" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    详情页描述
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" name="detail_descr"><?php echo isset($model) ? $model->detail_descr : ""; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品备注
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" name="pd_remark"><?php echo isset($model) ? $model->pd_remark : ""; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品关键词
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_key_word" value="<?php echo isset($model) ? $model->pd_key_word : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    市场价
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="market_price" value="<?php echo isset($model) ? $model->market_price : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    最小价
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="min_price" value="<?php echo isset($model) ? $model->min_price : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品图片集合前缀
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_picture_prefix" value="<?php echo isset($model) ? $model->pd_picture_prefix : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品信息图文详情
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <!-- 加载编辑器的容器 -->
                                                    {!! we_field('wangeditor', 'pd_detail_info', isset($model) ? $model->pd_detail_info : "") !!}
                                                    {!! we_config('wangeditor') !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品图片
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <a class="btn" id="btn">上传图片</a> 最大500KB，支持jpg，gif，png格式。
                                                    <ul id="ul_pics" class="ul_pics clearfix">
                                                        <?php
                                                        if (isset($model->pd_image_url)){
                                                            $li = explode(",",trim($model->pd_image_url,","));
                                                            foreach ($li as $v){
                                                                echo "<li><div class='img'><img width='200' src='http://".\Request::server('HTTP_HOST').$v."'></div></li>";
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    <input type="hidden" name="pd_image_url" value="<?php echo isset($model) ? $model->pd_image_url : ""; ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    商品封面图
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <a class="btntranslation" id="btntranslation">上传图片</a> 最大500KB，支持jpg，gif，png格式。
                                                    <ul id="translation_pic" class="translation_pic clearfix">
                                                        <?php
                                                        if (isset($model->pd_translation_pic)){
                                                            $li = explode(",",trim($model->pd_translation_pic,","));
                                                            foreach ($li as $v){
                                                                echo "<li><div class='img'><img width='200' src='https://".\Request::server('HTTP_HOST').$v."'></div></li>";
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    <input type="hidden" name="pd_translation_pic" value="<?php echo isset($model) ? $model->pd_translation_pic : ""; ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    排序
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pd_sort" value="<?php echo isset($model) ? $model->pd_sort : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    审核状态
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="radio" name="verify_status" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->verify_status) ? "checked" : "";?> >是
                                                    <input type="radio" name="verify_status" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->verify_status) ? "checked" : "";?> >否
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    详情页标题
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="detail_title" value="<?php echo isset($model) ? $model->detail_title : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="sku">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" style="height:38px;" name="prototype_name" placeholder="属性名">
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control" name="prototype_type" style="height:38px;">
                                                        <option value="radio">可选值</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="prototype_radio" style="display: block;">
                                                        <input type="text" class="form-control" data-role="tagsinput" name="prototype_value" placeholder="多个属性用英文','隔开">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="form-contorl btn btn-circle btn-danger" name="prototype_add"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <table class="table table-hover" id="prototype_container">
                                            </table>
                                            <table class="table table-bordered table-hover" id="prototype_collection">
                                                <thead>
                                                <tr>
                                                    <th class='col-md-1'> 属性 </th>
                                                    <th class='col-md-1'> 图片 </th>
                                                    <th class='col-md-1'> 会员价 </th>
                                                    <th class='col-md-1'> 价格 </th>
                                                    <th class='col-md-1'> 库存 </th>
                                                    <th class='col-md-1'> 库存预警值 </th>
                                                    <th class='col-md-1'> sku编号 </th>
                                                    {{--<th class='col-md-1'> 操作 </th>--}}
                                                <?php
                                                    /*
                                                    //取笛卡儿积
                                                    function CartesianProduct($sets){
                                                        // 保存结果
                                                        $result = array();
                                                        // 循环遍历集合数据
                                                        for($i=0,$count=count($sets); $i<$count-1; $i++){
                                                            // 初始化
                                                            if($i==0){
                                                                $result = $sets[$i];
                                                            }
                                                            // 保存临时数据
                                                            $tmp = array();
                                                            // 结果与下一个集合计算笛卡尔积
                                                            foreach($result as $res){
                                                                foreach($sets[$i+1] as $set){
                                                                    $tmp[] = $res.','.$set;
                                                                }
                                                            }
                                                            // 将笛卡尔积写入结果
                                                            $result = $tmp;
                                                        }
                                                        return $result;
                                                    }

                                                    $arr = [];
                                                    $top = [];
                                                    foreach ($categorySku as $k => $v){
                                                        foreach ($v->categorySkuProperties as $vv){
                                                            $arr[$k][] = $vv->sku_propertie_value;
                                                        }
                                                        //获取属性
                                                        $top[$k] = $v->propertie_name;
                                                    }

                                                    //得到笛卡儿积
                                                    $r = CartesianProduct($arr);

                                                    //属性展示
                                                    foreach ($top as $v){
                                                        echo "<th class='col-md-1'> $v </th>";
                                                    }
                                                    echo "<th class='col-md-1'> 价格 </th>";
                                                    echo "<th class='col-md-1'> 库存 </th>";
                                                    echo "<th class='col-md-1'> 库存预警值 </th>";
                                                    echo "<th class='col-md-1'> sku编号 </th>";
                                                    echo "<th class='col-md-1'> 操作 </th>";

                                                    $skuProperties = [];
                                                    if ($sku){
                                                        //属性对应库存，去重
                                                        foreach ($sku as $v){
                                                            if (in_array($v->skuProperties,$skuProperties)){
                                                                continue;
                                                            }
                                                            $skuProperties[] = $v->skuProperties;
                                                        }
                                                    }

                                                    //展示对应属性与库存
                                                    foreach ($r as $k => $v){
                                                        $ar = explode(",",$v);
                                                        $tds = "";
                                                        foreach($ar as $v){
                                                            $tds .= "<td class='tds'>{$v}</td>";
                                                        }

                                                        echo "
                                                                <tr sku_unique_code='".(isset($skuProperties[$k])?$skuProperties[$k]->sku_unique_code:"")."'>
                                                                {$tds}
                                                                <td><input type='text' class='form-control' name='pd_price[]' value='".(isset($skuProperties[$k])?$skuProperties[$k]->pd_price:"")."'></td>
                                                                <td><input type='text' class='form-control' name='pd_stocks[]' value='".(isset($skuProperties[$k])?$skuProperties[$k]->pd_stocks:"")."'></td>
                                                                <td><input type='text' class='form-control' name='pd_alarm_stocks[]' value='".(isset($skuProperties[$k])?$skuProperties[$k]->pd_alarm_stocks:"")."'></td>
                                                                <td><input type='text' class='form-control' name='sku_code[]' value='".(isset($skuProperties[$k])?$skuProperties[$k]->sku_code:"")."'></td>
                                                                <td></td>
                                                                </tr>";
                                                    }*/
                                                ?>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="seller_id" value="<?php echo $user->seller_id; ?>" >
                                    <input type="hidden" name="category_id" value="<?php //echo isset($category) ? $category->category_id : ""; ?>" class="form-control input-inline input-medium">
                                    <input type="hidden" name="sku" value="" class="form-control input-inline input-medium">
                                    <input type="hidden" name="top" value="<?php //echo count($top);?>" class="form-control input-inline input-medium">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button name="submit" type="submit" class="btn green">提交 <i class="m-icon-swapright m-icon-white"></i></button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" charset="utf-8" src="/resource/global/plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/global/scripts/product_sku.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function () {
        $('body').on("success", ".ajax-form", function (result) {
            location.href = "/selleradmin/productlog";
        });

        var text = "";
        var uploader = new plupload.Uploader({ //创建实例的构造方法
            runtimes: 'html5,flash,silverlight,html4',
            //上传插件初始化选用那种方式的优先级顺序
            browse_button: 'btn',
            // 上传按钮
            url: "/public/images",
            //远程上传地址
            flash_swf_url: 'plupload/Moxie.swf',
            //flash文件地址
            silverlight_xap_url: 'plupload/Moxie.xap',
            //silverlight文件地址
            filters: {
                max_file_size: '500kb',
                //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                mime_types: [ //允许文件上传类型
                    {
                        title: "files",
                        extensions: "jpg,png,gif"
                    }]
            },
            multi_selection: true,
            //true:ctrl多文件上传, false 单文件上传
            init: {
                FilesAdded: function(up, files) { //文件上传前
                    var al = $("#ul_pics").find('li').length;
                    if ( al > 9 ) {
                       swal({
                            title: "失败",
                            text: "最多只能上传10张图片！",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        uploader.destroy();
                    } else {
                        var li = '';
                        plupload.each(files,
                            function(file) { //遍历文件
                                li += "<li id='" + file['id'] + "'></li>";
                            });
                        $("#ul_pics").append(li);
                        uploader.start();
                    }
                },
                UploadProgress: function(up, file) { //上传中，显示进度条
                    // $("#" + file.id).find('.bar').css({
                    //     "width": file.percent + "%"
                    // }).find(".percent").text(file.percent + "%");
                },
                FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                    var data = JSON.parse(info.response);
                    text += data.file+",";
                    $("#" + file.id).append("<div class='img'><img width='200' src='" + data.url + "'/></div>");
                    $("input[name='pd_image_url']").val(text);
                },
                Error: function(up, err) { //上传出错的时候触发
                    alert(err.message);
                }
            }
        });
        uploader.init();

        window.uploadimg = function (a) {
            var text = "";
            var uploader = new plupload.Uploader({ //创建实例的构造方法
                runtimes: 'html5,flash,silverlight,html4',
                //上传插件初始化选用那种方式的优先级顺序
                browse_button: a,
                // 上传按钮
                url: "/public/images",
                //远程上传地址
                flash_swf_url: 'plupload/Moxie.swf',
                //flash文件地址
                silverlight_xap_url: 'plupload/Moxie.xap',
                //silverlight文件地址
                filters: {
                    max_file_size: '500kb',
                    //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                    mime_types: [ //允许文件上传类型
                        {
                            title: "files",
                            extensions: "jpg,png,gif"
                        }]
                },
                multi_selection: true,
                //true:ctrl多文件上传, false 单文件上传
                init: {
                    FilesAdded: function(up, files) { //文件上传前

                        if ($(a).siblings("ul").children("li").length > 9) {
                            swal({
                                title: "失败",
                                text: "最多只能上传10张图片！",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 1000
                            })
                            uploader.destroy();
                        } else {
                            $(a).siblings("ul").empty();//清楚子元素
                            var li = '';
                            plupload.each(files,
                                function(file) { //遍历文件
                                    li += "<li id='" + file['id'] + "'></li>";
                                });
                            $(a).siblings("ul").append(li);
                            uploader.start();
                        }
                    },
                    UploadProgress: function(up, file) { //上传中，显示进度条
                       /* $("#" + file.id).find('.bar').css({
                            "width": file.percent + "%"
                        }).find(".percent").text(file.percent + "%");*/
                    },
                    FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                        var data = JSON.parse(info.response);
                        text += data.file;
                        $("#" + file.id).append("<div class='img'><img width='200' src='" + data.url + "'/></div>");
                        $(a).siblings("input").val(text);
                    },
                    Error: function(up, err) { //上传出错的时候触发
                        alert(err.message);
                    }
                }
            });
            uploader.init();
        };

        var translationtext = "";
        var uploaderTranslation = new plupload.Uploader({ //创建实例的构造方法
            runtimes: 'html5,flash,silverlight,html4',
            //上传插件初始化选用那种方式的优先级顺序
            browse_button: 'btntranslation',
            // 上传按钮
            url: "/public/images",
            //远程上传地址
            flash_swf_url: 'plupload/Moxie.swf',
            //flash文件地址
            silverlight_xap_url: 'plupload/Moxie.xap',
            //silverlight文件地址
            filters: {
                max_file_size: '500kb',
                //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                mime_types: [ //允许文件上传类型
                    {
                        title: "files",
                        extensions: "jpg,png,gif"
                    }]
            },
            multi_selection: true,
            //true:ctrl多文件上传, false 单文件上传
            init: {
                FilesAdded: function(up, files) { //文件上传前
                    if ($("#translation_pic").children("li").length > 4) {
                       swal({
                            title: "失败",
                            text: "最多只能上传5张图片！",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        uploaderTranslation.destroy();
                    } else {
                        $("#translation_pic").empty();//清楚子元素
                        var li = '';
                        plupload.each(files,
                            function(file) { //遍历文件
                                li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                        $("#translation_pic").append(li);
                        uploaderTranslation.start();
                    }
                },
                UploadProgress: function(up, file) { //上传中，显示进度条
                    // $("#" + file.id).find('.bar').css({
                    //     "width": file.percent + "%"
                    // }).find(".percent").text(file.percent + "%");
                },
                FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                    console.log(translationtext);
                    var data = JSON.parse(info.response);
                    translationtext += data.file+",";
                    $("#" + file.id).append("<div class='img'><img width='200' src='" + data.url + "'/></div>");
                    $("input[name='pd_translation_pic']").val(translationtext);
                },
                Error: function(up, err) { //上传出错的时候触发
                    alert(err.message);
                }
            }
        });
        uploaderTranslation.init();

        <?php
            if (!empty($product_sku)){
                foreach ($product_sku as $v){
                    echo "collection.addPrototype('".$v->name."','radio','".$v->value."');";
                }
            }
        ?>

        collection.drawCollectionTables();
        collection.drawPrototypeTables();

        <?php
            if (!empty($sku_properties)){
                foreach ($sku_properties as $k => $v){
                    echo "collection.setBind('".$sku[$k]['property']."','".$v['pd_price']."','".$v['member_price']."','".$v['pd_stocks']."','".$v['pd_alarm_stocks']."','".$v['sku_code']."','".$v['sku_picture_url']."');";
                }
            }
        ?>

        $('#prototype_container').on('click','.prototype_remove',function(e){
            var name = $(this).parents('tr').find('td:first').html();
            collection.removePrototype(name);
            return false;
        });

        $('button[name=prototype_add]').on('click',function(){
            var name = $.trim($('input[name=prototype_name]').val());
            if(name.length==0)
            {
                alert("属性名或属性值不得为空");
                // App.alert({
                //     container: $('#alert_container').val(), // alerts parent container
                //     place: 'append', // append or prepent in container
                //     type: 'danger', // alert's type
                //     message: '属性名或属性值不得为空',
                //     close: true,
                //     focus: true, // auto scroll to the alert after shown
                //     closeInSeconds: 3, // auto close after defined seconds
                //     icon:'fa fa-remove' // put icon class before the message
                // });
                return false;
            }
            var type = $('select[name=prototype_type]').val();
            switch(type)
            {
                case 'text':
                    var value = $.trim($('#prototype_text').find('input').val());
                    break;
                case 'radio':
                    var value = $('#prototype_radio').find('input').val();
                    break;
                default:return false;
            }

            collection.addPrototype(name,type,value);
            collection.drawCollectionTables();
            collection.drawPrototypeTables();

            return false;
        });

        var arr = [];
        $("button[name=submit]").click(function () {
            //获取tr
            var list = $(".table-bordered tr"),
                arr = [],len = 0;
            //遍历tr
            list.each(function (index,element) {
                var subArr = new Array();
                //获取tr下子元素的个数
                len = $(element).children().length;
                //若子元素是th，将抬头放入数组中
                if (!index) {
                    $(element).find('th').each(function (index,e) {
                        if (index == (len-1)){
                            return;
                        }
                        subArr.push($(this).html());
                    });
                }
                //若子元素是td，将属性与库存放入数组中
                $(element).find('td').each(function (index,e) {
                    if (index == (len-1)){
                        return;
                    }
                    if ($(this).hasClass('tds')){
                        subArr.push($(this).html());
                    } else {
                        subArr.push($(this).find('input').val())
                    }
                });
                //拼接sku属性组唯一code
                var skuUniqueCode = $(element).attr("sku_unique_code");
                if (skuUniqueCode){
                    subArr.push(skuUniqueCode);
                }
                //拼接成数组
                arr.push(subArr);
            });
            //将拼接好的数据转成json存入input
            $("input[name='sku']").val(JSON.stringify(arr));
            //防止重复提交
            // $(this).attr('disabled',true);
            //表单提交
            $(".ajax-form").submit();
        });

        $("input[name='recommend_type']").change(function () {
            var arr = [];
            arr.push("0");
            $("input[name='recommend_type']").each(function (index,e) {
                arr.push((e.checked)?"1":"0");
            });

            $("input[name='pd_recommend_type']").val(arr.join(""));
        });

        $("input[name='service_guarantee']").change(function () {
            var arr = [];
            arr.push("0");
            $("input[name='service_guarantee']").each(function (index,e) {
                arr.push((e.checked)?"1":"0");
            });

            $("input[name='pd_service_guarantee']").val(arr.join(""));
        });
    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>