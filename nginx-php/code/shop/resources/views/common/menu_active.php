<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$active)){  ?>
    <li class="nav-item <?php
    echo in_array($code, [
        "newgiftbag",
        "newgiftbagcoupon",
        "coupontree",
        "coupontreebarrage",
        "matherbuild",
        "sharemoney",
        "christmas",
        "onedog",
        "icepoint",
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-puzzle"></i>
            <span class="title">活动</span>
            <?php
            if (in_array($code, [
                        "sign",
                        "newgiftbag",
                        "newgiftbagcoupon",
                        "coupontree",
                        "coupontreebarrage",
                        "matherbuild",
                        "sharemoney",
                        "christmas",
                        "onedog",
                        "icepoint",
                    ])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
    <?php } else { ?>
                <span class="arrow"></span>
    <?php } ?>
        </a>
        <ul class="sub-menu">
            <li class="nav-item <?php echo $code == "christmas" ? "active open" : "" ?>">
                <a href="/active/christmas" class="nav-link ">
                    <span class="title">圣诞节活动</span>
                    <?php echo $code == "christmas" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "newgiftbag" ? "active open" : "" ?>">
                <a href="/active/newgiftbag" class="nav-link ">
                    <span class="title">新手礼包</span>
                    <?php echo $code == "newgiftbag" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "newgiftbagcoupon" ? "active open" : "" ?>">
                <a href="/active/newgiftbagcoupon" class="nav-link ">
                    <span class="title">新手礼包优惠券</span>
                    <?php echo $code == "newgiftbagcoupon" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "coupontree" ? "active open" : "" ?>">
                <a href="/active/coupontree" class="nav-link ">
                    <span class="title">成长优惠券</span>
                    <?php echo $code == "coupontree" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "coupontreebarrage" ? "active open" : "" ?>">
                <a href="/active/coupontreebarrage" class="nav-link ">
                    <span class="title">成长优惠券弹幕</span>
                    <?php echo $code == "coupontreebarrage" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "matherbuild" ? "active open" : "" ?>">
                <a href="/active/matherbuild" class="nav-link ">
                    <span class="title">盖楼活动</span>
                    <?php echo $code == "matherbuild" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "sharemoney" ? "active open" : "" ?>">
                <a href="/active/sharemoney" class="nav-link ">
                    <span class="title">分享赚钱</span>
                    <?php echo $code == "sharemoney" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "onedog" ? "active open" : "" ?>">
                <a href="/active/onedog" class="nav-link ">
                    <span class="title">新年旺旺旺</span>
                    <?php echo $code == "onedog" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "icepoint" ? "active open" : "" ?>">
                <a href="/active/icepoint" class="nav-link ">
                    <span class="title">冰点暑价</span>
                    <?php echo $code == "icepoint" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            
            
        </ul>
    </li>
<?php } ?>