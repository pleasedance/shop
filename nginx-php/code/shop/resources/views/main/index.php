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
        <style>
            .row-fluid {
                display: flex;
                flex-direction: row;
            }
            .flex-block {
                flex: 1 1 auto;
                margin: 0 15px;
            }
            .flex-block .details {
                position: relative;
            }
        </style>
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
                    <h1 class="page-title"> 首页
                        <small>云息金控后台管理首页</small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="/">首页</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div id="dashboard">
                            <div class="row-fluid">
                                <div class="flex-block">
                                    <div class="dashboard-stat green-sharp">
                                        <div class="visual">
                                            <i class="fa fa-dot-circle-o"></i>
                                        </div>
                                        <div class="details">
                                            <div data-counter="counterup" class="number" data-value="<?php echo $companyNum; ?>">0</div>
                                            <div class="desc"> 平台商户数量 </div>
                                        </div>
                                        <a class="more" href="#"> info
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex-block">
                                    <div class="dashboard-stat grey-salsa">
                                        <div class="visual">
                                            <i class="fa fa-rmb"></i>
                                        </div>
                                        <div class="details">
                                            <div data-counter="counterup" class="number" data-value="<?php echo $userNum; ?>">0</div>
                                            <div class="desc"> 平台可用流量 </div>
                                        </div>
                                        <a class="more" href="#"> List
                                            <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
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
        <script src="/resource/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="/resource/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <!--<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>-->
        <!--<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />-->
        <!-- END PAGE LEVEL PLUGINS -->
        <script>
            jQuery(document).ready(function () {
                $("[data-counter='counterup']").counterUp({
                    delay: 10,
                    time: 1000
                });
            });
        </script>
        <!-- END JAVASCRIPTS -->
        <!-- END BODY -->
    </body>
</html>