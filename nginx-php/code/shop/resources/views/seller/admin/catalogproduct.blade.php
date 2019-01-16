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
    <?php echo View::make('common/menu', ["code" => "product"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 商品管理
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/selleradmin">商家管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">商品管理</a>
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
                                <span class="caption-subject bold uppercase">选择分类</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                             <div class="row">
                                <div class="col-md-3">
                                    <div class="portlet-body">
                                        <div class="table">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-2"> 分类名称 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $cat_list = json_decode(json_encode($list),true)['data'];
                                                    function getSon($id,$array=array(),$level=1){
                                                        $str = '';
                                                        static $lists;
                                                        foreach ($array as $k => $v) {
                                                            if( $v['parent_id'] == $id){

                                                                $flg = str_repeat('|--',$level);
                                                                $v['name'] = $flg.$v['name'];

                                                                echo '<tr><td category_id="'.$v['category_id'].'">'.$v['name'].'</td></tr>';

                                                                $lists[] = $v;
                                                                unset($array[$k]);
                                                                getSon($v['category_id'],$array,$level+1);
                                                            }
                                                        }
                                                    }
                                                    getSon(0,$cat_list);
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="page"><?php echo $list->links() ?></div>
                                    </div>
                                     <div>
                                        <a href="javascript:;" class="btn">确认</a>
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
            })

            var category_id = 0;
            //选中
            $(".portlet-body td").click(function () {
                category_id = $(this).attr('category_id');
                $(this).addClass('bgred').parent('tr').siblings().find('td').removeClass('bgred');
            });

            $(".btn").click(function () {
                if (category_id<=0){
                    alert.msg('请选择分类！',{'position':'center','background':'#32c5d2'});
                    return;
                }
                window.location.href = "/selleradmin/product/"+category_id;
            });
        });


    </script>
    <!-- END JAVASCRIPTS -->
    <!-- END BODY -->
</body>
</html>
<style>
    .bgred
    {
        background-color:#17C4BB;
        color: white;
    }
</style>