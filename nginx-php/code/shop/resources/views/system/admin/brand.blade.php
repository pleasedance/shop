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
<?php echo View::make('common/top_system'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php echo View::make('common/menu_user_system', ["code" => "brand"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 品牌管理
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/system/admin">商家管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">品牌管理</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/system/admin/brand/<?php echo isset($model)?$model->brand_id:"";?>" method="<?php echo isset($model) ? "put" : "post"; ?>" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            品牌名称
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="brand_name" value="<?php echo isset($model) ? $model->brand_name : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            品牌首字母
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="brand_initials" value="<?php echo isset($model) ? $model->brand_initials : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            logo图片URL
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <a id="logo" class="btn sbold green"></a>
                                            <input type="hidden" name="brand_logo_url" value="<?php echo isset($model) ? $model->brand_logo_url : ""; ?>" >
                                            <i class="fa fa-plus"></i>
                                            <div><img id="logoImage" style="width: 300px;" src="<?php echo isset($model)?"http://".\Request::server('HTTP_HOST').$model->brand_logo_url:"";?>"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            品牌专区大图URL
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <a id="detail" class="btn sbold green"></a>
                                            <input type="hidden" name="brand_detail_url" value="<?php echo isset($model) ? $model->brand_detail_url : ""; ?>" >
                                            <i class="fa fa-plus"></i>
                                            <div><img style="width: 300px;" id="detailImage" src="<?php echo isset($model)?"http://".\Request::server('HTTP_HOST').$model->brand_detail_url:"";?>"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            品牌故事介绍
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="brand_introduce"><?php echo isset($model) ? $model->brand_introduce : ""; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            是否显示
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="radio" name="is_show" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->is_show) ? "checked" : "checked";?> >是
                                            <input type="radio" name="is_show" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->is_show) ? "checked" : "";?> >否
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            排序
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="sort" value="<?php echo isset($model) ? $model->sort : ""; ?>" class="form-control input-inline input-medium">
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
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" charset="utf-8" src="/resource/global/plugins/jUploader.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function () {
        $('body').on("success", ".ajax-form", function (result) {
            location.href = "/system/admin/brandlog";
        });

        $.jUploader.setDefaults({
            cancelable: true, // 可取消上传
            allowedExtensions: ['jpg', 'gif', 'jpeg',"png"], // 只允许上传excel
            messages: {
                upload: '上传',
                cancel: '取消',
                emptyFile: "{file} 为空，请选择一个文件.",
                invalidExtension: "{file} 后缀名不合法. 只有 {extensions} 是允许的.",
                onLeave: "文件正在上传，如果你现在离开，上传将会被取消。"
            }
        });
        $.jUploader({
            button: 'logo', // 这里设置按钮id
            action: '/public/image',
            onUpload: function (fileName) {

            },
            onComplete: function (fileName, result) {
                $("input[name=brand_logo_url]").val(result.file)
                $("#logoImage").attr("src",result.url)
            }
        });
        $.jUploader({
            button: 'detail', // 这里设置按钮id
            action: '/public/image',
            onUpload: function (fileName) {

            },
            onComplete: function (fileName, result) {
                $("input[name=brand_detail_url]").val(result.file)
                $("#detailImage").attr("src",result.url)
            }
        });

    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>