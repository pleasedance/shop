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
        <link href="/resource/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
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
            <?php echo View::make('common/menu', ["code" => "index"]); ?>
            <!-- END SIDEBAR -->

            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> 个人设置
                        <small>个人设置</small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="/">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>个人设置</li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-body form">
                                    <form class="form-horizontal ajax-form" action="/profile" method="post">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    手机号
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="mobile" value="<?php echo $curUser ? $curUser->mobile : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    用户名
                                                    <span class="required" aria-required="true"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" value="<?php echo $curUser ? $curUser->name : ""; ?>" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    密码
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="password" name="password" placeholder="不填不修改" value="" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">
                                                    重复密码
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="password" name="repassword" value="" class="form-control input-inline input-medium">
                                                </div>
                                            </div>
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
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php echo View::make('common/footer'); ?>
        <!-- END FOOTER -->
        <?php echo View::make('common/corejs'); ?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <script>
            jQuery(document).ready(function () {
                $('body').on("success", ".ajax-form", function (result) {
                    location.reload()
                });
            });
        </script>
        <!-- END JAVASCRIPTS -->
        <!-- END BODY -->
    </body>
</html>