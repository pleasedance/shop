<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$customerService)){
?>
    <li class="nav-item <?php
    echo in_array($code, [
        "customerservice_message","customerservice_replay","customer_user"
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-phone"></i>
            <span class="title">客服</span>
            <?php
            if (in_array($code, [
                        "customerservice_message","customerservice_replay"
                    ])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
            <?php } else { ?>
                <span class="arrow"></span>
            <?php } ?>
        </a>
        <ul class="sub-menu">
            
            <li class="nav-item <?php echo $code == "customer_user" ? "active open" : "" ?>">
                <a href="/customerservice/user" class="nav-link ">
                    <span class="title">通讯录</span>
                    <?php echo $code == "customer_user" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "customerservice_message" ? "active open" : "" ?>">
                <a href="/customerservice/message" class="nav-link ">
                    <span class="title">消息</span>
                    <?php echo $code == "customerservice_message" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "customerservice_replay" ? "active open" : "" ?>">
                <a href="/customerservice/replay" class="nav-link ">
                    <span class="title">快捷回复</span>
                    <?php echo $code == "customerservice_replay" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            
        </ul>
    </li>
<?php } ?>