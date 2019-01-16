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
            <?php echo View::make('common/menu', ["code" => "order_user"]); ?>
            <!-- END SIDEBAR -->

            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> 商户订单
                        <small>流量</small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="/">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-user"></i>
                                商户订单
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                流量
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
                                        <span class="caption-subject bold uppercase">流量订单列表</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table">
                                                <ul class="nav nav-tabs">
                                                    <li<?php echo $status==App\Models\CompanyOrderModel::statusInit ? ' class="active"' :  '' ?>>
                                                        <a href="/order/user?status=<?php echo App\Models\CompanyOrderModel::statusInit ?>">待审核</a>
                                                    </li>
                                                    <li<?php echo $status==App\Models\CompanyOrderModel::statusSuccess ? ' class="active"' :  '' ?>>
                                                        <a href="/order/user?status=<?php echo App\Models\CompanyOrderModel::statusSuccess ?>">已通过</a>
                                                    </li>
                                                    <li<?php echo $status==App\Models\CompanyOrderModel::statusFail ? ' class="active"' :  '' ?>>
                                                        <a href="/order/user?status=<?php echo App\Models\CompanyOrderModel::statusFail; ?>">已拒绝</a>
                                                    </li>
                                                </ul>
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-2"> 订单号 </th>
                                                            <th class="col-md-2"> 商户名称 </th>
                                                            <th class="col-md-1"> 支付平台 </th>
                                                            <th class="col-md-2"> 支付单号 </th>
                                                            <th class="col-md-1"> 金额 </th>
                                                            <th class="col-md-3"> 备注 </th>
                                                            <th class="col-md-1"> 操作 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($list as $value) { ?>
                                                            <tr>
                                                                <td><?php echo $value->code; ?></td>
                                                                <td><?php echo App\Data\CompanyData::info($value->company_id)->name; ?></td>
                                                                <td><?php echo $value->payType->name; ?></td>
                                                                <td><?php echo $value->trade_no; ?></td>
                                                                <td><?php echo $value->money; ?></td>
                                                                <td><?php echo $value->remark; ?></td>
                                                                <td>
                                                                    <?php if($value->status==App\Models\CompanyOrderModel::statusInit){ ?>
                                                                    <a class="success" data-id="<?php echo $value->id; ?>">
                                                                        通过
                                                                    </a>
                                                                    <a class="fail" data-id="<?php echo $value->id; ?>">
                                                                        拒绝
                                                                    </a>
                                                                    <?php } ?>
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
                    $("body").on("success",".ajax",function(){
                        location.reload();
                    })
                    
                    $("body").on("click",".fail",function(){
                        var html='<div class="row"><div class="form-body"><div class="form-group">'+
                '<label class="col-md-3 control-label">理由<span class="required" aria-required="true"> * </span></label>'+
                '<div class="col-md-9"><input type="text" name="reason" class="form-control input-medium"></div>'+
            '</div></div></div>'
                        var id=$(this).attr("data-id");
                        bootbox.dialog({
                            title: "拒绝订单",
                            message: html,
                            buttons: {
                              success: {
                                label: "拒绝",
                                className: "green",
                                callback: function() {
                                    ajaxHttp("/order/user/status","delete",{id:id,reason:$("input[name=reason]").val()},function(){
                                        swal({
                                            title: "成功",
                                            text: "执行完成",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        })
                                        setTimeout(function(){
                                            location.reload();
                                        },1000)
                                    });
                                    return false;
                                }
                              },
                              main: {
                                label: "取消",
                                className: "blue",
                                callback: function() {
                                    return true;
                                }
                              }
                            }
                        });
                        return false;
                    })
                    
                    $("body").on("click",".success",function(){
                        var id=$(this).attr("data-id");
                        var html='<div class="row"><div class="form-body"><div class="form-group">'+
                '<label class="col-md-3 control-label">兑换流量数量<span class="required" aria-required="true"> * </span></label>'+
                '<div class="col-md-9"><input type="number" name="num" class="form-control input-medium"></div>'+
            '</div></div></div>'
                        bootbox.dialog({
                            title: "兑换流量",
                            message: html,
                            buttons: {
                              success: {
                                label: "兑换",
                                className: "green",
                                callback: function() {
                                    ajaxHttp("/order/user/status","post",{id:id,num:$("input[name=num]").val()},function(){
                                        swal({
                                            title: "成功",
                                            text: "执行完成",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        })
                                        setTimeout(function(){
                                            location.reload();
                                        },1000)
                                    });
                                    return false;
                                }
                              },
                              main: {
                                label: "取消",
                                className: "blue",
                                callback: function() {
                                    return true;
                                }
                              }
                            }
                        });
                        return false;
                    })
                });
            </script>
            <!-- END JAVASCRIPTS -->
            <!-- END BODY -->
    </body>
</html>