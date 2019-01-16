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
<?php echo View::make('common/top_company'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php echo View::make('common/menu_company', ["code" => "companyadmin"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 企业管理
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/company">系统管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">企业管理</a>
                    </li>
                    <li>
                        <?php //echo isset($list) ? "修改商户" : "添加商户"; ?>
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
                                <span class="caption-subject bold uppercase">企业管理</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row dataTables_wrapper">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="/companyadmin/add">
                                                    <button class="btn sbold green"> 添加
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a onclick="recharge()">
                                                    <button class="btn sbold green"> 充值
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
                                                        <th class="col-md-1"><input type="checkbox" name="checkAll" /></th>
                                                        <th class="col-md-2"> 企业名称 </th>
                                                        <th class="col-md-2"> 余额 </th>
                                                        <th class="col-md-1"> 状态 </th>
                                                        <th class="col-md-2"> 操作 </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($list as $value) { ?>
                                                    <tr>
                                                        <td><input type="checkbox" value="<?php echo $value->company_id;?>" name="companys" /></td>
                                                        <td><?php echo $value->name; ?></td>
                                                        <td><?php echo $value->money; ?></td>
                                                        <td><?php echo $value->status?"启用":"未启用"; ?></td>
                                                        <td>
                                                            <a href="/companyadmin/add/<?php echo $value->company_id;?>">编辑</a>
                                                            {{--<a href="/companyadmin/users">管理员列表</a>--}}
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
        <script type="text/javascript" charset="utf-8" src="/resource/alert.js"></script>
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
                });

                //全选
                $("input[name='checkAll']").click(function (event) {
                    $("input[name='companys']").prop('checked',$(this).prop('checked'));
                    event.stopPropagation();
                });

                //充值
                window.recharge = function () {
                    var companys = document.getElementsByName("companys");
                    var companyIds = [];
                    for (k in companys) {
                        if (companys[k].checked){
                            companyIds.push(companys[k].value);
                        }
                    }
                    if( companyIds == false ){
                        swal({
                            title: "失败",
                            text: "请选择充值对象！",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        return false;
                    }
                    var money=prompt("请输入充值金额！","");
                    if(money<1){
                        swal({
                            title: "失败",
                            text: "最小充值金额是1元！",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        return false;
                    }
                    if (money!=null && money!="")
                    {
                        ajaxHttp("/companyadmin/companyrecharge","post",{company_ids:companyIds,money:money},function(data){
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
                    }
                }
            });
        </script>
        <!-- END JAVASCRIPTS -->
        <!-- END BODY -->
</body>
</html>