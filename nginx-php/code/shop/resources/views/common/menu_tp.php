<?php
if (PermissionHelper::can(SessionHelper::get(), PermissionHelper::$thirdpart)){ ?>
    <li class="nav-item <?php
    echo in_array($code, [
        "erp_systrade", "erp_deliver", "erp_outstock","erp_statistics"
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-bug"></i>
            <span class="title">第三方对接</span>
            <?php
            if (in_array($code, ["erp_systrade", "erp_deliver", "erp_outstock","erp_statistics"])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
    <?php } else { ?>
                <span class="arrow"></span>
    <?php } ?>
        </a>
        <ul class="sub-menu">
            <li class="nav-item <?php echo in_array($code, ["erp_systrade", "erp_deliver", "erp_outstock","erp_statistics"]) ? "active open" : "" ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <span class="title">Erp管理</span>
                    <?php
                    if (in_array($code, [
                                "erp_systrade",
                                "erp_deliver",
                                "erp_outstock",
                                "erp_statistics"
                            ])) {
                        ?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
    <?php }else{ ?>
                        <span class="arrow"></span>
                            <?php } ?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php echo $code == "erp_statistics" ? "active open" : "" ?>">
                        <a href="/erp/statistics" class="nav-link ">
                            <span class="title">订单统计</span>
                            <?php echo $code == "erp_statistics" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "erp_systrade" ? "active open" : "" ?>">
                        <a href="/erp/systrade" class="nav-link ">
                            <span class="title">主订单管理</span>
                            <?php echo $code == "erp_systrade" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "erp_deliver" ? "active open" : "" ?>">
                        <a href="/erp/deliver" class="nav-link ">
                            <span class="title">发货单管理</span>
                            <?php echo $code == "erp_deliver" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "erp_outstock" ? "active open" : "" ?>">
                        <a href="/erp/outstock" class="nav-link ">
                            <span class="title">出货单管理</span>
                            <?php echo $code == "erp_outstock" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
<?php } ?>