<?php
$curUser = SessionHelper::get();
$wxManage = PermissionHelper::can($curUser, PermissionHelper::$wxManage);         //微信管理
$wxOperation = PermissionHelper::can($curUser, PermissionHelper::$wxOperation);         //微信运营

if ($wxManage || $wxOperation) {
    ?>
    <li class="nav-item <?php
    echo in_array($code, [
        "wx_address", "wxcs_keyword", "wxcs_updatelog", "wx_msg_group", "redpack", "redpack_onoff", "wxmenu", "wximagetext", "market", "followreplay"
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-wechat"></i>
            <span class="title">微信</span>
            <?php
            if (in_array($code, [
                        "wx_address", "wxcs_keyword", "wxcs_updatelog", "wx_msg_group", "keyword", "qr", "menu", "redpack", "redpack_onoff", "wxmenu", "wximagetext"
                    ])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
            <?php } else { ?>
                <span class="arrow"></span>
            <?php } ?>
        </a>
        <ul class="sub-menu">
            <?php if ($wxManage) { ?>
                <li class="nav-item <?php
                echo in_array($code, [
                    "wxmenu", "wx_msg_group", "market", "followreplay","wx_address"
                ]) ? "active open" : ""
                ?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title">管理</span>
                        <?php
                        if (in_array($code, [
                                    "wxmenu", "wx_msg_group", "market"
                                ])) {
                            ?>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        <?php } else { ?>
                            <span class="arrow"></span>
                        <?php } ?>
                    </a> 
                    <ul class="sub-menu">
                        <li class="nav-item <?php echo $code == "wx_address" ? "active open" : "" ?>">
                            <a href="/weixin/address" class="nav-link ">
                                <span class="title">通讯录</span>
                                <?php echo $code == "wx_address" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $code == "wxmenu" ? "active open" : "" ?>">
                            <a href="/wx/menu" class="nav-link nav-toggle">
                                <span class="title">微信菜单</span>
                                <?php if ($code == "wxmenu") { ?>
                                    <span class="selected"></span>
                                <?php } else { ?>
                                    <span class="arrow"></span>
                                <?php } ?>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $code == "wx_msg_group" ? "active open" : "" ?>">
                            <a href="/weixin/msggroup" class="nav-link ">
                                <span class="title">消息群发</span>
                                <?php echo $code == "wx_msg_group" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $code == "followreplay" ? "active open" : "" ?>">
                            <a href="/weixin/followreplay" class="nav-link ">
                                <span class="title">关注回复</span>
                                <?php echo $code == "followreplay" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>

                        <li class="nav-item <?php echo $code == "market" ? "active open" : "" ?>">
                            <a href="/weixin/market" class="nav-link ">
                                <span class="title">营销</span>
                                <?php echo $code == "market" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($wxOperation) { ?>
                <li class="nav-item <?php
                echo in_array($code, [
                    "wxcs_keyword", "wxcs_updatelog", "wximagetext", "redpack", "redpack_onoff"
                ]) ? "active open" : ""
                ?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title">运营</span>
                        <?php
                        if (in_array($code, [
                                    "wxcs_keyword", "wxcs_updatelog", "wximagetext", "redpack", "redpack_onoff"
                                ])) {
                            ?>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        <?php } else { ?>
                            <span class="arrow"></span>
                        <?php } ?>
                    </a> 
                    <ul class="sub-menu">

                        <li class="nav-item <?php echo $code == "wxcs_keyword" ? "active open" : "" ?>">
                            <a href="/weixin/keyword" class="nav-link ">
                                <span class="title">提醒关键词</span>
                                <?php echo $code == "wxcs_keyword" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>

                        <li class="nav-item <?php echo $code == "wxcs_updatelog" ? "active open" : "" ?>">
                            <a href="/weixin/updatelog" class="nav-link ">
                                <span class="title">更新说明</span>
                                <?php echo $code == "wxcs_updatelog" ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>

                        <li class="nav-item <?php echo $code == "wximagetext" ? "active open" : "" ?>">
                            <a href="/wx/image-text" class="nav-link nav-toggle">
                                <span class="title">微信图文库</span>
                                <?php if ($code == "wximagetext") { ?>
                                    <span class="selected"></span>
                                <?php } else { ?>
                                    <span class="arrow"></span>
                                <?php } ?>
                            </a>
                        </li>


                        <li class="nav-item <?php echo $code == "redpack" ? "active open" : "" ?>">
                            <a href="/redpack" class="nav-link nav-toggle">
                                <span class="title">红包管理</span>
                                <?php if ($code == "redpack") { ?>
                                    <span class="selected"></span>
                                <?php } else { ?>
                                    <span class="arrow"></span>
                                <?php } ?>
                            </a>
                        </li>

                        <li class="nav-item <?php echo $code == "redpack_onoff" ? "active open" : "" ?>">
                            <a href="/redpackreddraw" class="nav-link nav-toggle">
                                <span class="title">红包领取回访开关</span>
                                <?php if ($code == "redpack_onoff") { ?>
                                    <span class="selected"></span>
                                <?php } else { ?>
                                    <span class="arrow"></span>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>