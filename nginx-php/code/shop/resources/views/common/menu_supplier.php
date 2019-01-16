<?php
$mySupplierList = \Jstar\SupplierModel::where("uid", SessionHelper::get()->id)->get();
if ($mySupplierList->toArray()) {
    $supplierId = Input::get("supplier_id");
    ?>
    <li class="nav-item <?php echo in_array($code, ["supplier_product", "supplier_order","supplier_set"]) ? "active open" : "" ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-suitcase"></i>
            <span class="title">我的商户</span>
            <?php
            if (in_array($code, ["supplier_product", "supplier_order","supplier_set"])) {
                ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
            <?php } else { ?>
                <span class="arrow"></span>
            <?php } ?>
        </a>
        <ul class="sub-menu">
            <?php foreach ($mySupplierList as $supplierModel) { ?>
                <li class="nav-item <?php echo in_array($code, ["supplier_sku", "supplier_order","supplier_set"]) && $supplierId == $supplierModel->id ? "active open" : "" ?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title"><?php echo $supplierModel->name; ?></span>
                        <?php if (in_array($code, ["supplier_sku", "supplier_order","supplier_set"]) && $supplierId == $supplierModel->id) { ?>
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        <?php } else { ?>
                            <span class="arrow"></span>
                        <?php } ?>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?php echo $code == "supplier_set" && $supplierId == $supplierModel->id ? "active open" : "" ?>">
                            <a href="/supplier?supplier_id=<?php echo $supplierModel->id; ?>" class="nav-link ">
                                <span class="title">设置</span>
                                <?php echo $code == "supplier_sku" && $supplierId == $supplierModel->id ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $code == "supplier_product" && $supplierId == $supplierModel->id ? "active open" : "" ?>">
                            <a href="/supplier/product?supplier_id=<?php echo $supplierModel->id; ?>" class="nav-link ">
                                <span class="title">商品</span>
                                <?php echo $code == "supplier_product" && $supplierId == $supplierModel->id ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $code == "supplier_order" && $supplierId == $supplierModel->id ? "active open" : "" ?>">
                            <a href="/supplier/order?supplier_id=<?php echo $supplierModel->id; ?>" class="nav-link ">
                                <span class="title">订单</span>
                                <?php echo $code == "supplier_order" && $supplierId == $supplierModel->id ? '<span class="selected"></span>' : "" ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>