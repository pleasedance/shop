<?php
$curUser = SessionHelper::get();
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                <img src="/resource/layouts/layout2/img/logo-default.png" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <div class="page-actions">
        </div>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> <?php echo $curUser->username; ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
<!--                            <li>-->
<!--                                <a href="/profile">-->
<!--                                    <i class="icon-user"></i> 个人资料 </a>-->
<!--                            </li>-->
                            <li class="divider"> </li>
                            <li>
                                <a class="ajax logout" confirm="确定要退出登录？" method="delete" href="/seller">
                                    <i class="icon-logout"></i> 退出 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->

<script>
    window.onload=function (){
        $("body").on("success",".logout",function(){
            location.href="/seller";
        })
    }
    
    
</script>