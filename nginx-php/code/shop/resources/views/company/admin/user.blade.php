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
<?php echo View::make('common/top_company'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php echo View::make('common/menu_company', ["code" => "users"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 企业管理
                <small><?php echo isset($model) ? "修改" : "添加"; ?>管理员</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/companyadmin">系统管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">企业管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/companyadmin/user/<?php echo isset($model) ? $model->sys_user_id : ""; ?>" method="<?php echo isset($model) ? "put" : "post"; ?>">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            用户名
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="username" value="<?php echo isset($model) ? $model->username : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            密码
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="password" value="" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            邮箱
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="email" value="<?php echo isset($model) ? $model->email : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            角色
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="role_id" class="form-control input-inline input-medium">
                                                <option value="0">未选择角色</option>
                                                <?php
                                                foreach ($roles as $v){
                                                    echo "<option value='{$v->role_id}' ".((isset($model->role_id)&&($model->role_id==$v->role_id))?'selected':'').">{$v->role_name}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="loginid" value="<?php echo isset($model) ? $model->loginid : 0; ?>" >
                                    <input type="hidden" name="company_id" value="<?php echo isset($user) ? $user->company_id : 0; ?>" >
                                    <input type="hidden" name="sys_user_id" value="<?php echo isset($user) ? $user->sys_user_id : 0; ?>" >
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
            location.href = "/companyadmin/users";
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
    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>