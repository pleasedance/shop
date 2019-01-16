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
        <link href="/resource/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
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
            <?php echo View::make('common/menu', ["code" => "user"]); ?>
            <!-- END SIDEBAR -->

            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> 系统管理
                        <small>流量管理</small>
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
                                流量管理
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
                                        <span class="caption-subject bold uppercase">流量管理</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row dataTables_wrapper">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a id="import"  class="btn sbold green">
                                                         导入流量
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="/resource/usetmp.xlsx"  class="btn sbold green">
                                                         下载流量模板
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
                                                                <th class="col-md-1"> 姓名 </th>
                                                                <th class="col-md-1"> 手机号 </th>
                                                                <th class="col-md-2"> 身份证 </th>
                                                                <th class="col-md-2"> 银行卡 </th>
                                                                <th class="col-md-1"> 年龄 </th>
                                                                <th class="col-md-1"> 性别 </th>
                                                                <th class="col-md-1"> 来源 </th>
                                                                <th class="col-md-2"> 添加时间 </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($list as $value) { ?>
                                                                <tr>
                                                                    <td><?php echo $value->realname; ?></td>
                                                                    <td><?php echo $value->mobile ?></td>
                                                                    <td><?php echo $value->id_card ?></td>
                                                                    <td><?php echo $value->brank ?></td>
                                                                    <td><?php echo \DataBaseHelper::getAge(\DataBaseHelper::getBirthdayByIdCard($value->id_card)); ?></td>
                                                                    <td><?php
                                                                    $gender=\DataBaseHelper::checkManByIdCard($value->id_card);
                                                                    if($gender===TRUE){
                                                                        echo "男";
                                                                    }elseif($gender===FALSE){
                                                                        echo "女";
                                                                    }
                                                                    ?></td>
                                                                    <td>
                                                                        <?php
                                                                        switch ($value->from) {
                                                                            case App\Models\UserModel::fromExcel:
                                                                                echo "excel导入";
                                                                                break;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $value->created_at ?></td>
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
            <script type="text/javascript" charset="utf-8" src="/resource/global/plugins/jUploader.min.js"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <script>
                jQuery(document).ready(function () {
                    $.jUploader.setDefaults({
                        cancelable: true, // 可取消上传
                        allowedExtensions: ['xlsx', 'xls'], // 只允许上传excel
                        messages: {
                            upload: '上传',
                            cancel: '取消',
                            emptyFile: "{file} 为空，请选择一个文件.",
                            invalidExtension: "{file} 后缀名不合法. 只有 {extensions} 是允许的.",
                            onLeave: "文件正在上传，如果你现在离开，上传将会被取消。"
                        }
                    });
                    $.jUploader({
                        button: 'import', // 这里设置按钮id
                        action: '/user/import',
                        onUpload: function (fileName) {
                            $.blockUI({
                                message: '<div class="loading-message ' + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>',
                                baseZ: 1000,
                                css: {
                                    border: '0',
                                    padding: '0',
                                    backgroundColor: 'none'
                                },
                                overlayCSS: {
                                    backgroundColor: '#555',
                                    opacity: 0.1,
                                    cursor: 'wait'
                                }
                            });
                        },
                        onComplete: function (fileName, result) {
                            $.unblockUI();
                            swal({
                                title: "文件上传成功",
                                text: "正在前往查看导入结果",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 1000
                            })
                            setTimeout(function(){
                                location.href="/import";
                            },1000)
                        }
                    });
                });
            </script>
            <!-- END JAVASCRIPTS -->
            <!-- END BODY -->
    </body>
</html>