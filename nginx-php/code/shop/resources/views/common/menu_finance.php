<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$finance)){
?>
    <li class="nav-item <?php
    echo in_array($code, [
        "finance_list", "finance_statistic", "finance_business", "finance_wxpayrefund", "finance_wxbill","finance_refund"
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-rmb"></i>
            <span class="title">财务</span>
            <?php
            if (in_array($code, [
                        "finance_list", "finance_statistic", "finance_business", "finance_wxpayrefund", "finance_wxbill",
                    ])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
            <?php } else { ?>
                <span class="arrow"></span>
            <?php } ?>
        </a>
        <ul class="sub-menu">
            <li class="nav-item <?php echo $code == "finance_refund" ? "active open" : "" ?>">
                <a href="/finance/refund" class="nav-link ">
                    <span class="title">退款申请</span>
                    <?php echo $code == "finance_refund" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "finance_statistic" ? "active open" : "" ?>">
                <a href="/finance/statistic" class="nav-link ">
                    <span class="title">统计</span>
                    <?php echo $code == "finance_statistic" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "finance_list" ? "active open" : "" ?>">
                <a href="/finance" class="nav-link ">
                    <span class="title">明细</span>
                    <?php echo $code == "finance_list" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php
            echo in_array($code, [
                "finance_business", "finance_wxpayrefund", "finance_wxbill",
            ]) ? "active open" : ""
            ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <span class="title">微信</span>
                    <?php
                    if (in_array($code, [
                                "finance_business", "finance_wxpayrefund", "finance_wxbill",
                            ])) {
                        ?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php } else { ?>
                        <span class="arrow"></span>
                    <?php } ?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php echo $code == "finance_wxpayrefund" ? "active open" : "" ?>">
                        <a href="/finance/wxpayrefund" class="nav-link ">
                            <span class="title">售后退款</span>
                            <?php if ($code == "finance_wxpayrefund") { ?>
                                <span class="selected"></span>
                            <?php } else { ?>
                                <span class="arrow"></span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "finance_business" ? "active open" : "" ?>">
                        <a href="/finance/business" class="nav-link nav-toggle">
                            <span class="title">企业转账</span>
                            <?php if ($code == "finance_business") { ?>
                                <span class="selected"></span>
                            <?php } else { ?>
                                <span class="arrow"></span>
                            <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "finance_wxbill" ? "active open" : "" ?>">
                        <a href="/finance/wxbill" class="nav-link nav-toggle">
                            <span class="title">账单</span>
                            <?php if ($code == "finance_wxbill") { ?>
                                <span class="selected"></span>
                            <?php } else { ?>
                                <span class="arrow"></span>
                            <?php } ?>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
<?php } ?>