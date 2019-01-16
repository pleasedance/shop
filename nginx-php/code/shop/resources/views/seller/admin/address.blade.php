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
    <?php echo View::make('common/menu', ["code" => "address"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 商家地址管理
                <small><?php echo isset($model) ? "修改" : "添加"; ?>商家</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/selleradmin">系统管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">参数设置</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="/selleradmin/address/<?php echo isset($model) ? $model->id : ""; ?>">商家收货地址</a>
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
                            <form class="form-horizontal ajax-form" action="/selleradmin/address/<?php echo isset($model) ? $model->id : ""; ?>" method="<?php echo isset($model) ? "put" : "post"; ?>">
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
                                            收货人姓名
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="receive_name" value="<?php echo isset($model) ? $model->receive_name : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            收货人手机号
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="receive_phone" value="<?php echo isset($model) ? $model->receive_phone : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            收货地址所属省份
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="province" class="form-control input-inline input-medium" id="province">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            收货地址所属城市
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="city" class="form-control input-inline input-medium" id="city">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            收货地址所属区
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="area" class="form-control input-inline input-medium" id="area">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            详细地址
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="receive_address" value="<?php echo isset($model) ? $model->receive_address : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            邮政编码
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="post_number" value="<?php echo isset($model) ? $model->post_number : ""; ?>" class="form-control input-inline input-medium">
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
<input type="hidden" id="address" value=<?php echo json_encode(Config::get('address')); ?> >
<input type="hidden" class="province" value=<?php echo isset($model) ? $model->province : ""; ?> >
<input type="hidden" class="city" value=<?php echo isset($model) ? $model->city : ""; ?> >
<input type="hidden" class="area" value=<?php echo isset($model) ? $model->area : ""; ?> >
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
            location.href = "/selleradmin/addresslist";
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
            button: 'uploadLogo', // 这里设置按钮id
            action: '/public/image',
            onUpload: function (fileName) {

            },
            onComplete: function (fileName, result) {
                $("input[name=logo]").val(result.file)
                $("#logoImage").attr("src",result.url)
            }
        });
        $.jUploader({
            button: 'uploadBanner', // 这里设置按钮id
            action: '/public/image',
            onUpload: function (fileName) {

            },
            onComplete: function (fileName, result) {
                $("input[name=banner]").val(result.file)
                $("#bannerImage").attr("src",result.url)
            }
        });

        //省市区三级联动
        get_addess();
    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>