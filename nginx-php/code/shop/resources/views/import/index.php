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
            <?php echo View::make('common/menu', ["code" => "import"]); ?>
            <!-- END SIDEBAR -->

            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> 导入记录
                        <small>我的导入记录</small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="/">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                导入记录
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="fa fa-list"></i>
                                        <span class="caption-subject bold uppercase">我的导入列表</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table">
                                                <ul class="nav nav-tabs">
                                                    <li<?php echo $module==App\Models\ImportModel::moduleUser ? ' class="active"' :  '' ?>>
                                                        <a href="/import?module=<?php echo App\Models\ImportModel::moduleUser ?>">流量</a>
                                                    </li>
                                                </ul>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-2"> 导入时间 </th>
                                                            <th class="col-md-1"> 状态 </th>
                                                            <th class="col-md-7"> 失败说明 </th>
                                                            <th class="col-md-1"> 操作 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($list as $value) { ?>
                                                            <tr>
                                                                <td><?php echo $value->created_at; ?></td>
                                                                <td><?php
                                                                switch ($value->status) {
                                                                    case App\Models\ImportModel::statusInit:
                                                                        echo '<span class="label label-warning">正在导入</span>';
                                                                        break;
                                                                    case App\Models\ImportModel::statusSuccess:
                                                                        echo '<span class="label label-success">导入成功</span>';
                                                                        break;
                                                                    case App\Models\ImportModel::statusFail:
                                                                        echo '<span class="label label-danger">导入失败</span>';
                                                                        break;
                                                                }
                                                                ?></td>
                                                                <td><?php echo $value->error; ?></td>
                                                                <td>
                                                                    <a href="/import/download?id=<?php echo $value->id; ?>">
                                                                        下载
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="page"><?php echo $list->links() ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                        <!-- END CONTENT BODY -->
                    </div>
                    <!-- END CONTENT -->
                </div>
                <!-- END CONTAINER -->
            </div>
            <!-- BEGIN FOOTER -->
            <?php echo View::make('common/footer'); ?>
            <!-- END FOOTER -->
            <?php echo View::make('common/corejs'); ?>
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="/resource/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
            
            <!-- END PAGE LEVEL PLUGINS -->
            <script>
                jQuery(document).ready(function () {
                    
                });
            </script>
            <!-- END JAVASCRIPTS -->
            <!-- END BODY -->
    </body>
</html>