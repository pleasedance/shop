<?php if(PermissionHelper::can(SessionHelper::get(), PermissionHelper::$cms)){    
?>
    <li class="nav-item <?php
    echo in_array($code, [
        "cms_media_platforms", "cms_docclass", "cms_doc_comment", "cms_source", "cms_list", "topic", "discover",
        "material_image","material_video","material_voice","subject"
    ]) ? "active open" : ""
    ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-book"></i>
            <span class="title">内容管理</span>
            <?php
            if (in_array($code, [
                        "cms_media_platforms", "cms_docclass", "cms_doc_comment", "cms_source", "cms_list", "topic", "discover",
                        "material_image","material_video","material_voice","subject"
                    ])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
    <?php } else { ?>
                <span class="arrow"></span>
    <?php } ?>

        </a>
        <ul class="sub-menu">
            <li class="nav-item <?php echo $code == "cms_media_platforms" ? "active open" : "" ?>">
                <a href="/cms/mediaplatforms" class="nav-link ">
                    <span class="title">订阅源</span>
    <?php echo $code == "cms_media_platforms" ? '<span class="selected"></span>' : "" ?>

                </a>
            </li>
            <li class="nav-item <?php echo $code == "cms_list" ? "active open" : "" ?>">
                <a href="/cms/list" class="nav-link ">
                    <span class="title">文章</span>
    <?php echo $code == "cms_list" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "cms_docclass" ? "active open" : "" ?>">
                <a href="/cms/docclass" class="nav-link ">
                    <span class="title">文章分类</span>
    <?php echo $code == "cms_docclass" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "cms_doc_comment" ? "active open" : "" ?>">
                <a href="/cms/doc/comment" class="nav-link ">
                    <span class="title">文章评论</span>
    <?php echo $code == "cms_doc_comment" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "cms_source" ? "active open" : "" ?>">
                <a href="/cms/doc/source" class="nav-link ">
                    <span class="title">文章来源列表</span>
    <?php echo $code == "cms_source" ? '<span class="selected"></span>' : "" ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "topic" ? "active open" : "" ?>">
                <a href="/cms/topic" class="nav-link nav-toggle">
                    <span class="title">话题管理</span>
                    <?php if ($code == "topic") { ?>
                        <span class="selected"></span>
    <?php } else { ?>
                        <span class="arrow"></span>
    <?php } ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "subject" ? "active open" : "" ?>">
                <a href="/cms/subject" class="nav-link nav-toggle">
                    <span class="title">专题管理</span>
                    <?php if ($code == "subject") { ?>
                        <span class="selected"></span>
                    <?php } else { ?>
                        <span class="arrow"></span>
                    <?php } ?>
                </a>
            </li>
            <li class="nav-item <?php echo $code == "discover" ? "active open" : "" ?>">
                <a href="/cms/discover" class="nav-link nav-toggle">
                    <span class="title">发现管理</span>
                    <?php if ($code == "discover") { ?>
                        <span class="selected"></span>
    <?php } else { ?>
                        <span class="arrow"></span>
            <?php } ?>
                </a>
            </li>
            <li class="nav-item <?php
                    echo in_array($code, [
                        "material_image","material_video","material_voice"
                    ]) ? "active open" : ""
                    ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <span class="title">素材库</span>
                    <?php
                    if (in_array($code, [
                                "material_image","material_video","material_voice"
                            ])) {
                        ?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                            <?php } else { ?>
                        <span class="arrow"></span>
    <?php } ?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php echo $code == "material_image" ? "active open" : "" ?>">
                        <a href="/material/media/image" class="nav-link ">
                            <span class="title">图片</span>
    <?php echo $code == "material_image" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "material_video" ? "active open" : "" ?>">
                        <a href="/material/media/video" class="nav-link ">
                            <span class="title">视频</span>
    <?php echo $code == "material_video" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                    <li class="nav-item <?php echo $code == "material_voice" ? "active open" : "" ?>">
                        <a href="/material/media/voice" class="nav-link ">
                            <span class="title">语音</span>
    <?php echo $code == "material_voice" ? '<span class="selected"></span>' : "" ?>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
<?php }?>