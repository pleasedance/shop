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
    <?php echo View::make('common/menu_user_system', ["code" => "category"]); ?>
    <!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 分类管理
                <small><?php echo isset($model) ? "修改" : "添加"; ?>商家</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/system/admin">商家管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">分类管理</a>
                    </li>
                    <li>
                        <?php //echo isset($list) ? "修改商户" : "添加商户"; ?>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body form">
                            <form class="form-horizontal ajax-form" action="/system/admin/category/<?php echo isset($model) ? $model->category_id : ""; ?>" method="<?php echo isset($model) ? "put" : "post"; ?>">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            上级分类
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="parent_id" class="form-control input-inline input-medium">
                                                <option value="0">不选择上级分类</option>
                                                <?php
                                                    $p_category = json_decode(json_encode($p_category),true);
                                                    function getSon($id,$array=array(),$level=1){
                                                        $str = '';
                                                        static $lists;
                                                        foreach ($array as $k => $v) {
                                                            if( $v['parent_id'] == $id){

                                                                $flg = str_repeat('|--',$level);
                                                                $v['name'] = $flg.$v['name'];

                                                                echo "<option value=".$v['category_id']." ".((isset($model)&&($v['category_id']==$v['parent_id']))?'selected':'')." >".$v['name']."</option>";

                                                                $lists[] = $v;
                                                                unset($array[$k]);
                                                                getSon($v['category_id'],$array,$level+1);
                                                            }
                                                        }
                                                    }
                                                    getSon(0,$p_category);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            品牌
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="brand_id" class="form-control input-inline input-medium">
                                                <option value="0">未选择品牌</option>
                                                <?php
                                                foreach ($brand as $v){
                                                    echo "<option value=".$v->brand_id." ".((isset($model)&&($v->brand_id==$model->brand_id))?'selected':'')." >".$v->brand_name."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            分类名称
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="category_name" value="<?php echo isset($model) ? $model->name : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            分类描述
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="descr"><?php echo isset($model) ? $model->descr : ""; ?></textarea>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            分类图标
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="picture_url" value="<?php //echo isset($model) ? $model->picture_url : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            分类图片
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <a class="btn" id="btn">上传图片</a> 最大500KB，支持jpg，gif，png格式。
                                            <ul id="ul_pics" class="ul_pics clearfix">
                                                <?php
                                                if (isset($model->picture_url)){
                                                    $li = explode(",",trim($model->picture_url,","));
                                                    foreach ($li as $v){
                                                        echo "<li><div class='img'><img width='400' src='http://".\Request::server('HTTP_HOST').$v."'></div></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <input type="hidden" name="picture_url" value="<?php echo isset($model) ? $model->picture_url : ""; ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            级别
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="number" min="0" name="level" value="<?php echo isset($model) ? $model->level : ""; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            排序
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="sort" value="<?php echo isset($model) ? $model->sort : 1; ?>" class="form-control input-inline input-medium">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            导航栏是否显示
                                            <span class="required" aria-required="true">  </span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="radio" name="navigation_status" value="1" class="form-control input-inline" <?php echo (isset($model)&&$model->navigation_status) ? "checked" : "checked";?> >是
                                            <input type="radio" name="navigation_status" value="0" class="form-control input-inline" <?php echo (isset($model)&&!$model->navigation_status) ? "checked" : "";?> >否
                                        </div>
                                    </div>
                                    <input type="hidden" name="seller_id" value="<?php echo isset($model) ? $model->seller_id : $user->seller_id; ?>" >
                                    <input type="hidden" name="seller_phone" value="<?php echo isset($model) ? $model->seller_phone : $user->phone; ?>" class="form-control input-inline input-medium">
                                    <input type="hidden" name="seller_real_name" value="<?php echo isset($model) ? $model->seller_real_name : $user->real_name; ?>" class="form-control input-inline input-medium">
                                    <input type="hidden" name="seller_user_name" value="<?php echo isset($model) ? $model->seller_user_name : $user->loginid; ?>" class="form-control input-inline input-medium">
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
<input type="hidden" id="address" value=<?php echo json_encode(Config::get('address')); ?> >
<input type="hidden" class="province" value=<?php echo isset($model) ? $model->province : ""; ?> >
<input type="hidden" class="city" value=<?php echo isset($model) ? $model->city : ""; ?> >
<input type="hidden" class="area" value=<?php echo isset($model) ? $model->area : ""; ?> >
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" charset="utf-8" src="/resource/global/plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/resource/alert.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function () {
        //表单验证
        $('form').submit(function(){
            if( $("input[name='brand_id']").val() == false ){
                alert.msg('请选择品牌！',{'position':'center','background':'#32c5d2'});
                return false;
            }
            if( $("input[name='category_name']").val() == false ){
                alert.msg('请填写分类名称！',{'position':'center','background':'#32c5d2'});
                return false;
            }
            if( $("input[name='level']").val() == false ){
                alert.msg('请填写分类级别！',{'position':'center','background':'#32c5d2'});
                return false;
            }
            if( $("input[name='picture_url']").val() == false ){
                alert.msg('请上传图片!',{'position':'center','background':'#32c5d2'});
                return false;
            }
        })
        $('body').on("success", ".ajax-form", function (result) {
            location.href = "/system/admin/catalog";
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
                    if ($("#ul_pics").children("li").length > 30) {
                        alert("您上传的图片太多了！");
                        uploader.destroy();
                    } else {
                        $("#ul_pics").empty();//清楚子元素
                        var li = '';
                        plupload.each(files,
                            function(file) { //遍历文件
                                li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                        $("#ul_pics").append(li);
                        uploader.start();
                    }
                },
                UploadProgress: function(up, file) { //上传中，显示进度条
                    $("#" + file.id).find('.bar').css({
                        "width": file.percent + "%"
                    }).find(".percent").text(file.percent + "%");
                },
                FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                    var data = JSON.parse(info.response);
                    text += data.file+",";
                    $("#" + file.id).html("<div class='img'><img width='400' src='" + data.url + "'/></div>");
                    $("input[name='picture_url']").val(text);
                },
                Error: function(up, err) { //上传出错的时候触发
                    alert(err.message);
                }
            }
        });
        uploader.init();

        //省市区三级联动
        get_addess();
    });
</script>
<!-- END JAVASCRIPTS -->
<!-- END BODY -->
</body>
</html>