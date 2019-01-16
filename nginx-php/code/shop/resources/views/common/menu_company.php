<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->

        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <?php foreach (CompanyMenuHelper::get(CompanySessionHelper::get()) as $menu) { ?>
                <li class="nav-item start<?php echo CompanyMenuHelper::isActive($menu, $code) ? ' active open' : ''; ?>">
                    <a href="<?php echo CompanyMenuHelper::getHref($menu); ?>" class="nav-link nav-toggle">
                        <?php $icon = CompanyMenuHelper::getIcon($menu); ?>
                        <?php if ($icon) { ?>
                            <i class="<?php echo $icon; ?>"></i>
                        <?php } ?>
                        <span class="title"><?php echo CompanyMenuHelper::getName($menu); ?></span>
                        <span class="<?php echo CompanyMenuHelper::isActive($menu, $code) ? 'selected' : 'arrow'; ?>"></span>
                    </a>
                    <?php $items = CompanyMenuHelper::getItems($menu); ?>
                    <?php if ($items) { ?>
                        <ul class="sub-menu">
                            <?php foreach ($items as $menu) { ?>
                                <li class="nav-item <?php echo CompanyMenuHelper::isActive($menu, $code) ? ' active open' : ''; ?>">
                                    <a href="<?php echo CompanyMenuHelper::getHref($menu); ?>" class="nav-link ">
                                        <span class="title"><?php echo CompanyMenuHelper::getName($menu); ?></span>
                                    </a>
                                    <?php $items = CompanyMenuHelper::getItems($menu); ?>
                                    <?php if ($items) { ?>
                                        <ul class="sub-menu">
                                            <?php foreach ($items as $menu) { ?>
                                                <li class="nav-item<?php echo CompanyMenuHelper::isActive($menu, $code) ? ' active open' : ''; ?>">
                                                    <a href="<?php echo CompanyMenuHelper::getHref($menu); ?>" class="nav-link ">
                                                        <span class="title"><?php echo CompanyMenuHelper::getName($menu); ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>


        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->