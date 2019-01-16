<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$system)){ ?>
<li class="nav-item <?php echo in_array($code,["system","user_attribute","user","role","statistical","recharge"]) ? "active open" : "" ?>">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-cogs"></i>
        <span class="title">系统</span>
        <?php if(in_array($code,["system","user_attribute","user","role","statistical","recharge"])){ ?>
        <span class="selected"></span>
        <span class="arrow open"></span>
        <?php }else{ ?>
        <span class="arrow"></span>
        <?php } ?>
    </a>
    <ul class="sub-menu">
        <li class="nav-item <?php echo $code=="user" ? "active open" : "" ?>">
            <a href="/user" class="nav-link ">
                <span class="title">用户管理</span>
                <?php echo $code=="user" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
        <li class="nav-item <?php echo $code=="user_attribute" ? "active open" : "" ?>">
            <a href="/user/attribute" class="nav-link ">
                <span class="title">用户自定义属性</span>
                <?php echo $code=="user_attribute" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
        <li class="nav-item <?php echo $code=="role" ? "active open" : "" ?>">
            <a href="/role" class="nav-link ">
                <span class="title">角色管理</span>
                <?php echo $code=="role" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
        <li class="nav-item <?php echo $code=="statistical" ? "active open" : "" ?>">
            <a href="/statistical" class="nav-link ">
                <span class="title">数据统计</span>
                <?php echo $code=="statistical" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
        <li class="nav-item <?php echo $code=="recharge" ? "active open" : "" ?>">
            <a href="/recharge" class="nav-link ">
                <span class="title">充值管理</span>
                <?php echo $code=="recharge" ? '<span class="selected"></span>' : "" ?>
            </a>
        </li>
    </ul>
</li>
<?php } ?>