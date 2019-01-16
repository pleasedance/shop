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
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN HEADER -->
<?php echo View::make('common/top'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php echo View::make('common/menu', ["code" => "faretemplate"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 运费模板管理
                <small><?php echo isset($model) ? "修改" : "添加"; ?>运费模板</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/selleradmin">运费模板管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="/selleradmin/faretemplate/<?php echo isset($model) ? $model->tpl_id : ""; ?>">运费模板</a>
                        <!--                        <i class="fa fa-angle-right"></i>-->
                    </li>
                    <li>
                        <?php //echo isset($list) ? "修改商户" : "添加商户"; ?>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/selleradmin/faretemplate/<?php echo isset($model) ? $model->tpl_id : ""; ?>" method="<?php echo isset($model) ? "put" : "post"; ?>">
                                <div class="form-body">
                                    <!--<div class="form-group">
                                        <label class="col-md-3 control-label">
                                            商家用户名
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="seller_user_name" value="<?php //echo $model ? $model->name : ""; ?>" class="form-control input-inline input-medium">
                                            <span class="help-inline">.<?php //echo Config::get("company.domain") ?></span>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            运费模板名称
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="tpl_name" value="<?php echo isset($model) ? $model->tpl_name : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            宝贝地址
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="province" class="form-control input-inline input-medium" id="province">
                                            </select>
                                            <select name="city" class="form-control input-inline input-medium" id="city">
                                            </select>
                                            <select name="area" class="form-control input-inline input-medium" id="area">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            发货时间
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="send_time" class="form-control input-inline input-medium" id="area">
                                                <?php
                                                $base = 4;
                                                $num = 360;
                                                for ($i=4;$i<=$num;$i+=$base){
                                                    if (($i/24)<1){
                                                        //小于一天
                                                        $txt = $i."小时内";
//                                                        $val = date('Y-m-d H:i:s',time()+($i*3600));
                                                    }else{
                                                        //大于一天
                                                        $base = 24;
                                                        $day = ($i/24);
                                                        $txt = $day."天内";
//                                                        $val = date('Y-m-d H:i:s',strtotime('+'.$day.' day'));
                                                    }
                                                    echo '<option data-icon="fa fa-file" data-subtext="" value="'.$i.'" >'.$txt.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            是否包邮
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <label class="input-inline"><input type="radio" name="exemption_status" value="0" <?php echo (isset($model)&&!$model->exemption_status) ? "checked" : "";?>> 自定义运费</label>
                                            <label class="input-inline"><input type="radio" name="exemption_status" value="1" <?php echo (isset($model)&&$model->exemption_status) ? "checked" : "";?>> 卖家承担运费</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            计件方式
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                                <label class="input-inline"><input type="radio" name="pricing_model_type" value="0" <?php echo (isset($model)&&($model->pricing_model_type==0)) ? "checked" : "";?>> 按件计费</label>
                                                <label class="input-inline"><input type="radio" name="pricing_model_type" value="1" <?php echo (isset($model)&&($model->pricing_model_type==1)) ? "checked" : "";?>> 按重量计费</label>
                                                <label class="input-inline"><input type="radio" name="pricing_model_type" value="2" <?php echo (isset($model)&&($model->pricing_model_type==2)) ? "checked" : "";?>> 按体积</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            运送方式：
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            除指定地区外，其余地区的运费采用“默认运费”
                                        </div>
                                        <div class="col-md-9">
                                            <?php
                                            $textS1 = '';
                                            $textS2 = '';
                                            $textS3 = '';
                                            $textEnd1 = '';
                                            $textEnd2 = '';
                                            $textEnd3 = '';
                                            $haveHead1 = false;
                                            $haveHead2 = false;
                                            $haveHead3 = false;
                                            $textTemp1 = "";
                                            $textTemp2 = "";
                                            $textTemp3 = "";
                                            $num1 = 0;
                                            $num2 = 0;
                                            $num3 = 0;
                                            if (isset($model->carryMode)){
                                                foreach ($model->carryMode as $v){
                                                    $time = mt_rand(10000,1000000000);
                                                    switch ($model->pricing_model_type){
                                                        case "0":
                                                            if ($v->transfer_type == 0){
                                                                if ($num1 == 0){
                                                                    $textS1 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd1 = '</div>';
                                                                }
                                                                $num1++;
                                                                if ($v->area == "默认"){
                                                                    $textS1 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_number[]" value="'.$v->basics_number.'" class="" style="width:3%">件内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_number[]" value="'.$v->extra_number.'" class="" style="width:3%">件，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a></div></div>';
                                                                    if(!$haveHead1){
                                                                        $haveHead1 = true;
                                                                        $textS1 .= "<div class='head'><span>运送到</span><span></span><span>首件数（件）</span><span>首费（元）</span><span>续件数（件）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp1 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_number[]" value="'.$v->basics_number.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_number[]" value="'.$v->extra_number.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 1){
                                                                if ($num2 == 0){
                                                                    $textS2 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd2 = '</div>';
                                                                }
                                                                $num2++;
                                                                if ($v->area == "默认"){
                                                                    $textS2 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_number[]" value="'.$v->basics_number.'" class="" style="width:3%">件内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_number[]" value="'.$v->extra_number.'" class="" style="width:3%">件，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead2){
                                                                        $haveHead2 = true;
                                                                        $textS2 .= "<div class='head'><span>运送到</span><span></span><span>首件数（件）</span><span>首费（元）</span><span>续件数（件）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp2 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_number[]" value="'.$v->basics_number.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_number[]" value="'.$v->extra_number.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 2){
                                                                if ($num3 == 0){
                                                                    $textS3 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd3 = '</div>';
                                                                }
                                                                $num3++;
                                                                if ($v->area == "默认"){
                                                                    $textS3 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_number[]" value="'.$v->basics_number.'" class="" style="width:3%">件内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_number[]" value="'.$v->extra_number.'" class="" style="width:3%">件，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead3){
                                                                        $haveHead3 = true;
                                                                        $textS3 .= "<div class='head'><span>运送到</span><span></span><span>首件数（件）</span><span>首费（元）</span><span>续件数（件）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp3 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_number[]" value="'.$v->basics_number.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_number[]" value="'.$v->extra_number.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            break;
                                                        case "1":
                                                            if ($v->transfer_type == 0){
                                                                if ($num1 == 0){
                                                                    $textS1 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd1 = '</div>';
                                                                }
                                                                $num1++;
                                                                if ($v->area == "默认"){
                                                                    $textS1 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_weight[]" value="'.$v->basics_weight.'" class="" style="width:3%">kg内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_weight[]" value="'.$v->extra_weight.'" class="" style="width:3%">kg，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead1){
                                                                        $haveHead1 = true;
                                                                        $textS1 .= "<div class='head'><span>运送到</span><span></span><span>首重（KG）</span><span>首费（元）</span><span>续重（KG）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp1 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_weight[]" value="'.$v->basics_weight.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_weight[]" value="'.$v->extra_weight.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 1){
                                                                if ($num2 == 0){
                                                                    $textS2 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd2 = '</div>';
                                                                }
                                                                $num2++;
                                                                if ($v->area == "默认"){
                                                                    $textS2 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_weight[]" value="'.$v->basics_weight.'" class="" style="width:3%">kg内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_weight[]" value="'.$v->extra_weight.'" class="" style="width:3%">kg，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead2){
                                                                        $haveHead2 = true;
                                                                        $textS2 .= "<div class='head'><span>运送到</span><span></span><span>首重（KG）</span><span>首费（元）</span><span>续重（KG）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp2 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_weight[]" value="'.$v->basics_weight.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_weight[]" value="'.$v->extra_weight.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 2){
                                                                if ($num3 == 0){
                                                                    $textS3 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd3 = '</div>';
                                                                }
                                                                $num3++;
                                                                if ($v->area == "默认"){
                                                                    $textS3 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_weight[]" value="'.$v->basics_weight.'" class="" style="width:3%">kg内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_weight[]" value="'.$v->extra_weight.'" class="" style="width:3%">kg，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead3){
                                                                        $haveHead3 = true;
                                                                        $textS3 .= "<div class='head'><span>运送到</span><span></span><span>首重（KG）</span><span>首费（元）</span><span>续重（KG）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp3 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_weight[]" value="'.$v->basics_weight.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_weight[]" value="'.$v->extra_weight.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            break;
                                                        case "2":
                                                            if ($v->transfer_type == 0){
                                                                if ($num1 == 0){
                                                                    $textS1 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd1 = '</div>';
                                                                }
                                                                $num1++;
                                                                if ($v->area == "默认"){
                                                                    $textS1 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_volume[]" value="'.$v->basics_volume.'" class="" style="width:3%">m³内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_volume[]" value="'.$v->extra_volume.'" class="" style="width:3%">m³，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead1){
                                                                        $haveHead1 = true;
                                                                        $textS1 .= "<div class='head'><span>运送到</span><span></span><span>首体积（m³）</span><span>首费（元）</span><span>续体积（m³）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp1 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_volume[]" value="'.$v->basics_volume.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_volume[]" value="'.$v->extra_volume.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 1){
                                                                if ($num2 == 0){
                                                                    $textS2 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd2 = '</div>';
                                                                }
                                                                $num2++;
                                                                if ($v->area == "默认"){
                                                                    $textS2 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_volume[]" value="'.$v->basics_volume.'" class="" style="width:3%">m³内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_volume[]" value="'.$v->extra_volume.'" class="" style="width:3%">m³，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead2){
                                                                        $haveHead2 = true;
                                                                        $textS2 .= "<div class='head'><span>运送到</span><span></span><span>首体积（m³）</span><span>首费（元）</span><span>续体积（m³）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp2 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_volume[]" value="'.$v->basics_volume.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_volume[]" value="'.$v->extra_volume.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            if ($v->transfer_type == 2){
                                                                if ($num3 == 0){
                                                                    $textS3 = '<div class="panel panel-default"><div class="panel-body">';
                                                                    $textEnd3 = '</div>';
                                                                }
                                                                $num3++;
                                                                if ($v->area == "默认"){
                                                                    $textS3 .= '<input type="hidden" name="areas[]" value="">默认运费<input type="text" name="basics_volume[]" value="'.$v->basics_volume.'" class="" style="width:3%">m³内
                                                                                <input type="text" name="basics_price[]" value="'.$v->basics_price.'" class="" style="width:3%">元，
                                                                                每增加<input type="text" name="extra_volume[]" value="'.$v->extra_volume.'" class="" style="width:3%">m³，
                                                                                增加运费<input type="text" name="extra_price[]" value="'.$v->extra_price.'" class="" style="width:3%">元
                                                                                <div><a href="javascript:;" class="o-item">为指定地区城市设置运费</a>';
                                                                    if(!$haveHead3){
                                                                        $haveHead3 = true;
                                                                        $textS3 .= "<div class='head'><span>运送到</span><span></span><span>首体积（m³）</span><span>首费（元）</span><span>续体积（m³）</span><span>续费（元）</span><span>操作</span></div>";
                                                                    }
                                                                }else{
                                                                    $textTemp3 .= '<div class="trs"><div class="area"><input type="hidden" name="areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><input type="text" name="basics_volume[]" value="'.$v->basics_volume.'"></span><span><input type="text" name="basics_price[]" value="'.$v->basics_price.'"></span><span><input type="text" name="extra_volume[]" value="'.$v->extra_volume.'"></span><span><input type="text" name="extra_price[]" value="'.$v->extra_price.'"></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                }
                                                            }
                                                            break;
                                                    }
                                                }
                                            }
                                            ?>
                                                <div>
                                                    <label class="input-inline"><input type="checkbox" name="transfer_type[]" value="0" <?php echo ($num1>0)?"checked":"";?>> 快递</label>
                                                    <div class="restext">
                                                        <?php
                                                        echo $textS1.$textTemp1.$textEnd1;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="input-inline"><input type="checkbox" name="transfer_type[]" value="1" <?php echo ($num2>0)?"checked":"";?>> EMS</label>
                                                    <div class="restext">
                                                        <?php
                                                        echo $textS2.$textTemp2.$textEnd2;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="input-inline"><input type="checkbox" name="transfer_type[]" value="2" <?php echo ($num3>0)?"checked":"";?>> 平邮</label>
                                                    <div class="restext">
                                                        <?php
                                                        echo $textS3.$textTemp3.$textEnd3;
                                                        ?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <input type="checkbox" name="requirement_status" value="1" <?php echo (!empty($model->requirement_status))?"checked":"";?> >指定条件包邮
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9 incl_div">
                                            <?php
                                                $text = '';
                                                if (isset($model->incPostageProviso)){
                                                    $text .= '<div class="head"><span>选择地区</span><span></span><span>设置包邮条件</span><span>操作</span></div>';
                                                    switch ($model->pricing_model_type){
                                                        case "0":
                                                            foreach ($model->incPostageProviso as $v){
                                                                $time = mt_rand(10000,1000000000);
                                                                if ($v->num&&$v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">件数</option><option value="1">金额</option><option value="2" selected>件数+金额</option></select><div class="divs">满<input type="text" name="num[]" value="'.$v->num.'">件,<input type="text" name="money[]" value="'.$v->money.'">元以上包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->num){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0" selected>件数</option><option value="1">金额</option><option value="2">件数+金额</option></select><div class="divs">满<input type="text" name="num[]" value="'.$v->num.'">件包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">件数</option><option value="1" selected>金额</option><option value="2">件数+金额</option></select><div class="divs">满<input type="text" name="money[]" value="'.$v->money.'">元包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                            }
                                                            break;
                                                        case "1":
                                                            foreach ($model->incPostageProviso as $v){
                                                                $time = mt_rand(10000,1000000000);
                                                                if ($v->weight&&$v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">重量</option><option value="1">金额</option><option value="2" selected>重量+金额</option></select><div class="divs">在<input type="text" name="weight[]" value="'.$v->weight.'">KG内，<input type="text" name="money[]" value="'.$v->money.'">元以上包邮</div></span><a onclick="add_div(this)">添加</a><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->weight){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0" selected>重量</option><option value="1">金额</option><option value="2">重量+金额</option></select><div class="divs">在<input type="text" name="weight[]" value="'.$v->weight.'">KG内包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">重量</option><option value="1" selected>金额</option><option value="2">重量+金额</option></select><div class="divs">满<input type="text" name="money[]" value="'.$v->money.'">元包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                            }
                                                            break;
                                                        case "2":
                                                            foreach ($model->incPostageProviso as $v){
                                                                $time = mt_rand(10000,1000000000);
                                                                if ($v->volume&&$v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">体积</option><option value="1">金额</option><option value="2" selected>体积+金额</option></select><div class="divs">在<input type="text" name="volume[]" value="'.$v->volume.'">m³内,<input type="text" name="money[]" value="'.$v->money.'">元以上包邮</div></span><a onclick="add_div(this)">添加</a><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->volume){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0" selected>体积</option><option value="1">金额</option><option value="2">体积+金额</option></select><div class="divs">在<input type="text" name="volume[]" value="'.$v->volume.'">m³内包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                                if ($v->money){
                                                                    $text .= '<div class="trs"><div class="area"><input type="hidden" name="incl_areas[]" value="'.$v->area.'"></div><span id="'.$time.'">'.$v->area.'</span><span><a onclick="editArea('.$time.')" href="javascript:;" data-toggle="modal" data-target="#myModal">编辑</a></span><span><select name="select_in" onchange="inclPostage(this)"><option value="0">体积</option><option value="1" selected>金额</option><option value="2">体积+金额</option></select><div class="divs">满<input type="text" name="money[]" value="'.$v->money.'">元包邮</div></span><span><a onclick="add_div(this)">添加</a></span><span><a onclick="del(this)">删除</a></span></div>';
                                                                    continue;
                                                                }
                                                            }
                                                            break;
                                                    }
                                                    echo $text;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <input type="hidden" name="seller_id" value="<?php echo isset($model) ? $model->seller_id : $user->seller_id; ?>" >
                                    <input type="hidden" name="seller_phone" value="<?php echo isset($model) ? $model->seller_phone : $user->phone; ?>" class="form-control input-inline input-medium">
                                    <input type="hidden" name="seller_real_name" value="<?php echo isset($model) ? $model->seller_real_name : $user->real_name; ?>" class="form-control input-inline input-medium">
                                    <input type="hidden" name="seller_user_name" value="<?php echo isset($model) ? $model->seller_user_name : $user->loginid; ?>" class="form-control input-inline input-medium">
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green">提交 <i class="m-icon-swapright m-icon-white"></i></button>
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
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        选择区域
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="test-div">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                    <button type="button" class="btn btn-primary btntest1">
                        确定
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<?php
isset($model->address)?preg_match('/(.*?(省|自治区|北京|天津|上海|重庆|台湾|行政区))+(.*?(市|自治州|地区|区划|县|市辖区|行政单位))+(.*?(区|县|镇|乡|街道|旗|海域|岛))/', $model->address, $matches):$matches=[];
?>
<input type="hidden" id="address" value=<?php echo json_encode(Config::get('address')); ?> >
<input type="hidden" class="province" value=<?php echo isset($model) ? $matches['1'] : ""; ?> >
<input type="hidden" class="city" value=<?php echo isset($model) ? $matches['3'] : ""; ?> >
<input type="hidden" class="area" value=<?php echo isset($model) ? $matches['5'] : ""; ?> >
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" charset="utf-8" src="/resource/global/plugins/jUploader.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/alert.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>

    jQuery(document).ready(function () {
        $('body').on("success", ".ajax-form", function (result) {
            location.href = "/selleradmin/faretemplatelist";
        });

        
        //省市区三级联动
        get_addess();

        //表单验证
        $('form').submit(function(){
            var alertConfig = {'position':'center','background':'#32c5d2'};
            if( $("input[name='tpl_name']").val() == false )
            {
                alert.msg('请输入运费模板名称！',alertConfig);
                return false;
            }

            if( $("input[name='exemption_status']").val() == 0 && $("input[name='pricing_model_type']").val() == 0 && $("input[name='transfer_type[]']").val() == 0)
            {
                 if (confirm('使用默认运费?')==true){
                    return true;
                 }else{
                    alert.msg('请填写运费信息！',alertConfig);
                    return false;
                 }
            }
        })
        //是否包邮
        $("input[name='exemption_status']").change(function(){

            var index = $(this).parents('.form-group').index();
            //选择包邮
            if( $(this).val() == 1 ){

                $('.form-group:gt('+index+')').hide();
            }else{

                 $('.form-group:gt('+index+')').show();
            }
        })
        
        //运送方式不同返回表单不同
        $("input[name='transfer_type[]']").change(function () {
            var input = $(this);
            if (input.get(0).checked){
                //选中状态
                $.ajax({
                    type: "POST",
                    url: "/selleradmin/carrymode",
                    data: {
                        'pricing_model_type':$("input[name='pricing_model_type']:checked").val(),
                    },
                    dataType: "json",
                    success: function(data){
                        var html = data['result'];
                        input.parent(".input-inline").siblings(".restext").html(html);
                        input.parent(".input-inline").siblings(".restext").show();
                    }
                });
            }else{
                //未选中状态
                input.parent(".input-inline").siblings(".restext").hide();
            }
        });

        //计件方式改变
        $("input[name='pricing_model_type']").change(function () {
            var input = $(this);
            $(".restext").empty();
            $("input[name='transfer_type[]']").removeAttr('checked');
            //清空条件包邮div并取消选中按钮
            $(".incl_div").empty();
            $("input[name='requirement_status']").removeAttr('checked');
        });

        //指定条件包邮
        $("input[name='requirement_status']").change(function () {
            var input = $(this);
            var time = (new Date()).valueOf();
            if (input.get(0).checked) {
                input.parent().siblings().append("<div class='head'><span>选择地区</span><span></span><span>设置包邮条件</span><span>操作</span></div>");
                var pricing_model_type = $("input[name='pricing_model_type']:checked").val();
                if (pricing_model_type == 0){
                    input.parent().siblings().append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>件数</option><option value='1'>金额</option><option value='2'>件数+金额</option></select><div class='divs'>满<input type='text' name='num[]'>件包邮</div></span><span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                }
                if (pricing_model_type == 1){
                    input.parent().siblings().append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>重量</option><option value='1'>金额</option><option value='2'>重量+金额</option></select><div class='divs'>在<input type='text' name='weight[]'>KG内包邮</div></span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                }
                if (pricing_model_type == 2){
                    input.parent().siblings().append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>体积</option><option value='1'>金额</option><option value='2'>体积+金额</option></select><div class='divs'>在<input type='text' name='volume[]'>m³内包邮</div></span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                }
            }else{
                $(".incl_div").empty();
            }
        });

        window.add_div = function(a)
        {
            var html = $(a).parents(".trs").html();
            var pricing_model_type = $("input[name='pricing_model_type']:checked").val();
            var time = (new Date()).valueOf();
            switch (pricing_model_type) {
                case '0':
                    $(".incl_div").append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>件数</option><option value='1'>金额</option><option value='2'>件数+金额</option></select><div class='divs'>满<input type='text' name='num[]'>件包邮</div></span><span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                    break;
                case '1':
                    $(".incl_div").append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>重量</option><option value='1'>金额</option><option value='2'>重量+金额</option></select><div class='divs'>在<input type='text' name='weight[]'>KG内包邮</div></span><span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                    break;
                case '2':
                    $(".incl_div").append("<div class='trs'><div class='area'><input type='hidden' name='incl_areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><select name='select_in' onchange='inclPostage(this)'><option value='0'>体积</option><option value='1'>金额</option><option value='2'>体积+金额</option></select><div class='divs'>在<input type='text' name='volume[]'>m³内包邮</div></span><span><a onclick='add_div(this)'>添加</a></span><span><a onclick='del(this)'>删除</a></span></div>");
                    break;
            }
        }

        window.del = function(a)
        {
            $(a).parents(".trs").remove();
        };

        window.inclPostage = function(select){
            var selected = $(select).find("option:selected").val();
            $(select).siblings(".divs").remove();//清空表单
            var pricing_model_type = $("input[name='pricing_model_type']:checked").val();
            switch (selected) {
                case '0':
                    switch (pricing_model_type) {
                        case '0':
                            $(select).after("<div class='divs'>满<input type='text' name='num[]'>件包邮</div>");
                            break;
                        case '1':
                            $(select).after("<div class='divs'>在<input type='text' name='weight[]'>KG内包邮</div>");
                            break;
                        case '2':
                            $(select).after("<div class='divs'>在<input type='text' name='volume[]'>m³内包邮</div>");
                            break;
                    }
                    break;
                case '1':
                    $(select).after("<div class='divs'>满<input type='text' name='money[]'>元包邮</div>");
                    break;
                case '2':
                    switch (pricing_model_type) {
                        case '0':
                            $(select).after("<div class='divs'>满<input type='num' name='num[]'>件，<input type='text' name='money[]'>元以上包邮</div>");
                            break;
                        case '1':
                            $(select).after("<div class='divs'>在<input type='weight' name='weight[]'>KG内，<input type='text' name='money[]'>元以上包邮</div>");
                            break;
                        case '2':
                            $(select).after("<div class='divs'>在<input type='weight' name='volume[]'>m³内，<input type='text' name='money[]'>元以上包邮</div>");
                            break;
                    }
                    break;
            }
        }

        //为指定地区城市设置运费
        $('body').on("click", ".o-item",function () {
            var item = $(this).parent();
            var pricing_model_type = $("input[name='pricing_model_type']:checked").val();
            var time = (new Date()).valueOf();
            if (pricing_model_type == 0){
                if (!item.children('div:first').hasClass('head')){
                    //判断是否有标题头部
                    item.append("<div class='head'><span>运送到</span><span></span><span>首件数（件）</span><span>首费（元）</span><span>续件数（件）</span><span>续费（元）</span><span>操作</span></div>");
                }
                item.append("<div class='trs'><div class='area'><input type='hidden' name='areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><input type='text' name='basics_number[]'  ></span><span><input type='text' name='basics_price[]'  ></span><span><input type='text' name='extra_number[]'  ></span><span><input type='text' name='extra_price[]'  ></span><span><a onclick='del(this)'>删除</a></span></div>");
            }
            if (pricing_model_type == 1){
                if (!item.children('div:first').hasClass('head')) {
                    //判断是否有标题头部
                    item.append("<div class='head'><span>运送到</span><span></span><span>首重（KG）</span><span>首费（元）</span><span>续重（KG）</span><span>续费（元）</span><span>操作</span></div>");
                }
                item.append("<div class='trs'><div class='area'><input type='hidden' name='areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><input type='text' name='basics_weight[]'  ></span><span><input type='text' name='basics_price[]'  ></span><span><input type='text' name='extra_weight[]'  ></span><span><input type='text' name='extra_price[]'  ></span><span><a onclick='del(this)'>删除</a></span></div>");
            }
            if (pricing_model_type == 2){
                if (!item.children('div:first').hasClass('head')) {
                    //判断是否有标题头部
                    item.append("<div class='head'><span>运送到</span><span></span><span>首体积（m³）</span><span>首费（元）</span><span>续体积（m³）</span><span>续费（元）</span><span>操作</span></div>");
                }
                item.append("<div class='trs'><div class='area'><input type='hidden' name='areas[]'></div><span id='"+time+"'>未添加地区</span><span><a onclick='editArea("+time+")' href='javascript:;' data-toggle='modal' data-target='#myModal'>编辑</a></span><span><input type='text' name='basics_volume[]'  ></span><span><input type='text' name='basics_price[]'  ></span><span><input type='text' name='extra_volume[]'  ></span><span><input type='text' name='extra_price[]'  ></span><span><a onclick='del(this)'>删除</a></span></div>");
            }
        });

        var timeA = "";
        window.editArea = function(time)
        {
            timeA = time;
        }
        //生成地区
        GetRegionPlug();
        //选择后确定按钮
        $(".btntest1").click(function () {
            var areas = GetChecked().join(",");//已选择的城市名
            $("#"+timeA).html(areas);//显示在页面
            $("#"+timeA).siblings(".area").find('input').val(areas);//存入隐藏的input
            $('#myModal').modal('hide');//完后隐藏模态框
        });
    });

</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
<style>
    .head{
        display: flex;
        align-items: center;
        height: 30px;
        background: #f7f7f7;
    }
    .trs{
        display: flex;
        align-items: center;
        min-height: 30px;
    }
    .head span,.trs span{
        display: inline-block;
        width: 14%;
        text-align: center;
    }
    .trs span input{
        width: 60%;
    }
.panel-body{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.5), 1px -2px 4px 0 rgba(0,0,0,.3);
}

/*选择区域*/
a.btntest{
    display: block;
    padding: 5px 10px;
    margin-bottom: 20px;
    background-color: #00b3ee;
}
.display-none{
    display: none;
}
.checkbtn a{
    font-size: 15px;
    color: #333;
    text-decoration: none;
    cursor: pointer;
}
.ri{
    float: right;
}
.clearfloat:after{display:block;clear:both;content:"";visibility:hidden;height:0}
.clearfloat{zoom:1}
.place-div>div{
    width: 100%;
    background: #f5f5f5;
    padding: 20px;
}
.place{
    display: inline-block;
    width:25%;
    height:30px;
    position: relative;
    box-sizing: border-box;
    border-top:2px solid #fff;
    border-left:2px solid #fff;
    border-right:2px solid #fff;
    padding-left:10px;
}
.place-active{
    border-top:2px solid #CAE4FF;
    border-left:2px solid #CAE4FF;
    border-right:2px solid #CAE4FF;
    background-color: #EDF6FF;
}
.place-div .placegroup{
    margin-left: 15px;
    width: 100%;
    background-color: #fff;
    padding: 20px;
    box-sizing: border-box;
    position: relative;
}
.place-div .checkbtn{
    background-color: #FBFBFB;
    margin: 0 10px 0 15px;
    width: 100%;
}
.place-div .checkbtn img{
    height: 10px;
    margin-left: 3px;
}
.place-div .checkbtn .allCheck img{
    height: 8px;
}
.place-div .checkbtn .ri{
    border-right: none;
}
.place-div .checkbtn a{
    border-right: 1px solid #ccc;
    height: 30px;
    line-height: 30px;
    display: inline-block;
    width: 60px;
    text-align: center;
}
.place-div .bigplace label{
    display: inline-block;
    float: left;
    width: 100%;
    font-weight: bold;
    text-align: left;
    height:30px;
    cursor: pointer;
}
.place-div .bigplace input,.place-div .smallplace input{
    margin-top: 3px;
    margin-right: 5px;
    float: left;
    height: auto;
}
.place-div .smallplace{
    position: absolute;
    top:28px;
    left:-2px;
    width:300px;
    z-index: 2;
    display: none;
    border:2px solid #CAE4FF;
    background-color: #EDF6FF;
    padding-left:10px;
}
.place-div .smallplace .ratio{
    color: red;
}
.colorEDF6FF{
    background-color: #EDF6FF;
}
.place-div .smallplace label{
    padding-right: 10px;
    text-align: left;
    display: inline-block;
    float: left;
    cursor: pointer;
}
.place-div .smallplace .citys{
    width: auto;
    background-color: #fff;
    position: absolute;
    top: 30px;
    border: 1px solid #ccc;
    z-index: 100;
    display: none;
}
.place-div .smallplace .place-tooltips:hover .citys{
    display: block;
}
.place-div .smallplace .citys>i.jt{
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 10px solid #ccc;
    position: absolute;
    top: -10px;
    left: 20px;
}
.place-div .smallplace .citys>i.jt i{
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 10px solid #fff;
    position: absolute;
    top: 2px;
    left: -8px;
}
.place-div .smallplace .citys .row-div{
    min-width: 250px;
    padding: 10px;
    box-sizing: border-box;
}
.place-div .smallplace .citys .row-div label span{
    max-width: 175px;
    float: left;
}
.place-div .smallplace .citys .row-div p{
    float: left;
    min-width: 115px;
}
.place-div .smallplace p{
    float: left;
    width: auto;
    margin: 0;
    margin-bottom: 10px;
    margin-top: 5px;
}
.place-div .smallplace>div{
    float: left;
    width: auto;
    margin: 0;
    padding-bottom: 10px;
    padding-top: 5px;
    position: relative;
    font-size: 0.9em;
}

.show-place-div .smallplace label{
    width: auto;
}
.show-place-div{
    margin-left: 85px;
    font-size: 15px;
}
.show-place-div .bigplace input, .show-place-div .smallplace input{
    margin-left: 0;
}
.show-place-div .smallplace .citys .row-div p{
    margin: 5px 0 10px 0;
}
</style>
</html>