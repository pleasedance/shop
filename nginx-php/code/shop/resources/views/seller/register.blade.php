
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="zh-CN" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh-CN" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh-CN" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>商户后台管理 | 注册</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="/resource/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/resource/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/resource/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="/resource/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/resource/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
</head>
<!-- END HEAD -->

<body class=" login">
    <!-- BEGIN : LOGIN PAGE 5-1 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 bs-reset">
                <div class="login-bg" style="background-image:url(/resource/bg1.jpg)">
                    <img class="login-logo" src="/resource/logo.png" /> </div>
            </div>
            <div class="col-md-6 login-container bs-reset">
                <div class="login-content" style="margin-top: 25%">
                    <h1>商户后台管理 注册界面</h1>
                    <p> 当前版本v1.0.0 </p>
                    <form action="/seller" class="form-horizontal ajax-form" method="post">
                        <div class="form-group col-md-12">
                            <div class="col-md-6">
                                <input class="form-control" type="text" autocomplete="off" placeholder="手机号" name="mobile" required/>
                            </div>
                            <div class="col-md-6">
                                <a method="post" class="btn btn-success sendSms">发送验证码</a>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-6">
                                <input class="form-control" autocomplete="off" type="text" autocomplete="off" placeholder="验证码" name="code" required/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-6">
                                <input class="form-control" autocomplete="off" type="password" autocomplete="off" placeholder="密码" name="password" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-4 col-md-6">
                                <button class="btn green">登录</button>
                            </div>
                        </div>
                    </form>
                    <!-- BEGIN FORGOT PASSWORD FORM -->
                    <!-- END FORGOT PASSWORD FORM -->
                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-md-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p> © 2018 | 觅集科技</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php echo View::make('common/corejs'); ?>
    <!-- END : LOGIN PAGE 5-1 -->
    <!--[if lt IE 9]>
<script src="/resource/global/plugins/respond.min.js"></script>
<script src="/resource/global/plugins/excanvas.min.js"></script>
<script src="/resource/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
    <script src="/resource/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            $('.login-bg').backstretch(["/resource/bg1.jpg", "/resource/bg2.jpg", "/resource/bg3.jpg"], {fade: 1000, duration: 8000});
            $('.login-form input').keypress(function (e) {
                if (e.which == 13) {
                    $('.ajax-form').submit(); //form validation success, call ajax form submit
                    return false;
                }
            });

            function lessNum(dom,num){
                $(dom).find("span").html(num);
                num=num-1;
                if(num>=0){
                    setTimeout(function(){
                        lessNum(dom,num);
                    },1000);
                }else{
                    $(dom).removeClass("default");
                    $(dom).html("发送验证码");
                    $(dom).addClass("sendSms");
                }
            }
            $("body").on("success", ".ajax-form", function () {
                location.href="/";
            })

            $("body").on("click", ".sendSms", function () {
                var _this=this;
                var mobile = $("input[name=mobile]").val();
                if (!mobile) {
                    $.bootstrapGrowl("请填写手机号", {
                        ele: 'body',
                        type: "danger",
                        offset: {
                            from: "top",
                            amount: 20
                        },
                        align: "right",
                        width: "auto",
                        delay: 5000,
                        allow_dismiss: true,
                        stackup_spacing: 10
                    });
                    return;
                }
                ajaxHttp("/passport/sms","post",{mobile:mobile}, function (result) {
                    $(_this).removeClass("sendSms");
                    $(_this).html("重新发送(<span></span>)");
                    $(_this).addClass("default");
                    lessNum(_this,60);
                });
            })
        })



    </script>
</body>
</html>