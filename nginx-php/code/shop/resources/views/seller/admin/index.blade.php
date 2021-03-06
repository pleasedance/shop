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
    <?php echo View::make('common/menu', ["code" => "root"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 商户管理
                <small>商户列表</small>
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
                        商户管理
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        商户列表
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
                                <span class="caption-subject bold uppercase">商户列表</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row dataTables_wrapper">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="/company/form">
                                                <button class="btn sbold green"> 添加
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet-body">
                                        <div class="table">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-2"> 名称 </th>
                                                    <th class="col-md-1"> 余额 </th>
                                                    <th class="col-md-1"> 剩余流量 </th>
                                                    <th class="col-md-1"> 剩余短信 </th>
                                                    <th class="col-md-1"> 每日流量限额 </th>
                                                    <th class="col-md-2"> 访问域名 </th>
                                                    <th class="col-md-1"> 状态 </th>
                                                    <th class="col-md-2"> 操作 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $list = [];
                                                foreach ($list as $value) { ?>
                                                    <tr>
                                                        <td><?php echo $value->name; ?></td>
                                                        <td><?php echo $value->money; ?></td>
                                                        <td><?php echo $value->user ? $value->user->num : 0; ?></td>
                                                        <td><?php echo $value->sms ? $value->sms->num : 0; ?></td>
                                                        <td><?php echo $value->user ? $value->user->limit : 0; ?></td>
                                                        <td><?php echo $value->code ?>.<?php echo Config::get("company.domain") ?></td>
                                                        <td>
                                                            <?php
                                                            switch($value->status){
                                                                case  App\Models\CompanyModel::statusActive:
                                                                    echo '<span class="label label-success">启用</span>';
                                                                    break;
                                                                case  App\Models\CompanyModel::statusInactive:
                                                                    echo '<span class="label label-danger">禁用</span>';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value->status== App\Models\CompanyModel::statusActive){ ?>
                                                                <a class="btn btn-circle ajax" confirm="确定要禁用该商户" method="delete" href="/company/status?id=<?php echo $value->id; ?>">
                                                                    禁用
                                                                </a>
                                                            <?php }else{ ?>
                                                                <a class="btn btn-circle ajax" confirm="确定要启用该商户" method="post" href="/company/status?id=<?php echo $value->id; ?>">
                                                                    启用
                                                                </a>
                                                            <?php } ?>
                                                            <a class="btn btn-circle" href="/company/form?id=<?php echo $value->id; ?>">
                                                                编辑
                                                            </a>

                                                            <div class="btn-group">
                                                                <a class="btn btn-circle" href="javascript:;" data-toggle="dropdown">
                                                                    更多操作
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <?php if($value->status== App\Models\CompanyModel::statusActive){ ?>
                                                                        <li>
                                                                            <a data-id='<?php echo $value->id; ?>' class="assign">分配流量</a>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <li>
                                                                        <a href="/company/assign?id=<?php echo $value->id; ?>">流量分配记录</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/company/sms?id=<?php echo $value->id; ?>">短信记录</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/company/statement/sms?id=<?php echo $value->id; ?>">短信明细</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/company/statement/user?id=<?php echo $value->id; ?>">流量明细</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/company/statement/money?id=<?php echo $value->id; ?>">余额明细</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="page"><?php //echo $list->links() ?></div>
                                    </div>
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
            $('body').on("success", ".ajax", function () {
                location.reload();
            });

            $("body").on("click",".assign",function(){
                var id=$(this).attr("data-id");
                var html='<div class="row"><div class="form-body"><div class="form-group">'+
                    '<label class="col-md-3 control-label">分配流量<span class="required" aria-required="true"> * </span></label>'+
                    '<div class="col-md-9"><input type="number" name="num" class="form-control input-medium"></div>'+
                    '</div></div></div>'
                bootbox.dialog({
                    title: "分配流量",
                    message: html,
                    buttons: {
                        success: {
                            label: "分配",
                            className: "green",
                            callback: function() {
                                ajaxHttp("/company/assign","post",{id:id,num:$("input[name=num]").val()},function(){
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