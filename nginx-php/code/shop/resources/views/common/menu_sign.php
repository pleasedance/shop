<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$sign)){ ?>
<li class="nav-item <?php echo in_array($code,["sign_main","sign_remedy","sign_order"]) ? "active open" : "" ?>">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-cogs"></i>
        <span class="title">签到</span>
        <?php if(in_array($code,["sign_main","sign_remedy","sign_order"])){ ?>
        <span class="selected"></span>
        <span class="arrow open"></span>
        <?php }else{ ?>
        <span class="arrow"></span>
        <?php } ?>
    </a>
    <ul class="sub-menu">
        <li class="nav-item <?php echo $code=="sign_main" ? "active open" : "" ?>">
            <a href="/sign" class="nav-link ">
                <span class="title">管理</span>
                <?php echo $code=="sign_main" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
<!--        <li class="nav-item <?php echo $code=="sign_remedy" ? "active open" : "" ?>">
            <a href="/sign/remedy" class="nav-link ">
                <span class="title">补签卡</span>
                <?php echo $code=="sign_remedy" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
        <li class="nav-item <?php echo $code=="sign_order" ? "active open" : "" ?>">
            <a href="/sign/order" class="nav-link ">
                <span class="title">补签卡订单</span>
                <?php echo $code=="sign_order" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>-->
    </ul>
</li>
<?php } ?>