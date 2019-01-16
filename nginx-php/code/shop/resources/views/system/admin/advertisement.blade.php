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
<?php echo View::make('common/top_system'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php echo View::make('common/menu_user_system', ["code" => "advertisement"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 广告设置
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/system/admin">系统管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">广告设置</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/system/admin/advertisement/<?php echo isset($model)?$model->ad_id:"";?>" method="<?php echo isset($model) ? "put" : "post"; ?>" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            广告名称
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="ad_name" value="<?php echo isset($model) ? $model->ad_name : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            广告位置
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="ad_position" class="form-control input-inline input-medium" id="ad_position">
                                                <option value="">未选择位置</option>
                                                <option value="0">小程序首页轮播</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            广告图片
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <a class="btn" id="btn">上传图片</a> 最大500KB，支持jpg，gif，png格式。
                                            <ul id="ul_pics" class="ul_pics clearfix">
                                                <?php
                                                if (isset($model->ad_picture)){
                                                    $li = explode(",",trim($model->ad_picture,","));
                                                    foreach ($li as $v){
                                                        echo "<li><div class='img'><img width='200' src='http://".\Request::server('HTTP_HOST').$v."'></div></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <input type="hidden" name="ad_picture" value="<?php echo isset($model) ? $model->ad_picture : ""; ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            广告链接
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="ad_url" value="<?php echo isset($model) ? $model->ad_url : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            广告备注
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="remarks"><?php echo isset($model) ? $model->remarks : ""; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            是否上线
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="radio" name="start" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->start_status) ? "checked" : "";?> >是
                                            <input type="radio" name="start" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->start_status) ? "checked" : "";?> >否
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            是否小程序链接
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="radio" name="type" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->type) ? "checked" : "";?> >是
                                            <input type="radio" name="type" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->type) ? "checked" : "";?> >否
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
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" charset="utf-8" src="/resource/global/plugins/plupload/js/plupload.full.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function () {
        $('body').on("success", ".ajax-form", function (result) {
            location.href = "/system/admin/advertisements";
        });

        var text = "";
        var uploader = new plupload.Uploader({ //创建实例的构造方法
            runtimes: 'html5,flash,silverlight,html4',
            //上传插件初始化选用那种方式的优先级顺序
            browse_button: 'btn',
            // 上传按钮
            url: "/public/images",
            //远程上传地址
            flash_swf_url: 'plupload/Moxie.swf',
            //flash文件地址
            silverlight_xap_url: 'plupload/Moxie.xap',
            //silverlight文件地址
            filters: {
                max_file_size: '500kb',
                //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                mime_types: [ //允许文件上传类型
                    {
                        title: "files",
                        extensions: "jpg,png,gif"
                    }]
            },
            multi_selection: true,
            //true:ctrl多文件上传, false 单文件上传
            init: {
                FilesAdded: function(up, files) { //文件上传前
                    var al = $("#ul_pics").find('li').length;
                    if ( al > 4 ) {
                        swal({
                            title: "失败",
                            text: "最多只能上传5张图片！",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        uploader.destroy();
                    } else {
                        var li = '';
                        plupload.each(files,
                            function(file) { //遍历文件
                                li += "<li id='" + file['id'] + "'></li>";
                            });
                        $("#ul_pics").append(li);
                        uploader.start();
                    }
                },
                UploadProgress: function(up, file) { //上传中，显示进度条
                    // $("#" + file.id).find('.bar').css({
                    //     "width": file.percent + "%"
                    // }).find(".percent").text(file.percent + "%");
                },
                FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                    var data = JSON.parse(info.response);
                    text += data.file+",";
                    $("#" + file.id).append("<div class='img'><img width='200' src='" + data.url + "'/></div>");
                    $("input[name='ad_picture']").val(text);
                },
                Error: function(up, err) { //上传出错的时候触发
                    alert(err.message);
                }
            }
        });
        uploader.init();

    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>