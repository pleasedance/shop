<?php
$curUser=SessionHelper::get();
$mallOperation=PermissionHelper::can($curUser, PermissionHelper::$mallOperation);                 //商城运营
$mallManage=PermissionHelper::can($curUser, PermissionHelper::$mallManage);                //商城管理
$mallMarketing=PermissionHelper::can($curUser, PermissionHelper::$mallMarketing);                 //商城营销 

if($mallOperation || $mallManage || $mallMarketing ){ ?>
<li class="nav-item <?php echo in_array($code,[
"mall_order","mall_cs","mall_goods","mall_tmp","mall_brand","mall_goodscate","mall_kuaidi_tmp","mall_freefreight","mall_page","mall_comment",
"mall_hot_tags","mall_coupon","mall_notice","mall_discount","mall_partner_shop","category","search","new_ad",
"attribute","ad","adware","ad_raider","bindingphone","orderpagenotice","mall_erpstock","mall_raider","coupon_comment","mall_pre_search","gold_bag","mall_product","supplier_manage","mall_return","special","subtraction"
]) ? "active open" : "" ?>">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-shopping-cart"></i>
        <span class="title">商城</span>
        <?php if(in_array($code,[
            "mall_order","mall_cs","mall_goods","mall_tmp","mall_brand","mall_goodscate","mall_kuaidi_tmp","mall_freefreight","mall_comment",
            "mall_hot_tags","mall_coupon","mall_notice","mall_discount","mall_partner_shop","category","search","new_ad",
            "attribute","ad","adware","ad_raider","bindingphone","orderpagenotice","mall_erpstock","mall_raider","coupon_comment","mall_pre_search","gold_bag","mall_product","supplier_manage","mall_return","special","subtraction"
            
            ])){ ?>
        <span class="selected"></span>
        <span class="arrow open"></span>
        <?php }else{ ?>
        <span class="arrow"></span>
        <?php } ?>
    </a>
    <ul class="sub-menu">
        <?php if($mallOperation){?>
        <li class="nav-item <?php echo in_array($code,[
"mall_goods","mall_goodscate","mall_order","mall_cs","mall_freefreight","mall_tmp","mall_hot_tags","mall_notice",
"mall_notice","adware","ad","orderpagenotice","mall_pre_search","mall_product","search","new_ad"
]) ? "active open" : "" ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <span class="title">运营</span>
                <?php if(in_array($code,[
                    "mall_goods","mall_goodscate","mall_order","mall_cs","mall_freefreight","mall_tmp","mall_hot_tags","mall_notice",
                    "mall_notice","adware","ad","orderpagenotice","mall_pre_search","mall_product","search","new_ad"
                    ])){ ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
                <?php }else{ ?>
                <span class="arrow"></span>
                <?php } ?>
            </a>
            <ul class="sub-menu">
               <li class="nav-item <?php echo $code=="mall_goods" ? "active open" : "" ?>">
                    <a href="/vue/mall/operation/goods/list" class="nav-link ">
                        <span class="title">宝贝</span>
                        <?php echo $code=="mall_goods" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_product" ? "active open" : "" ?>">
                    <a href="/mall/operation/product" class="nav-link ">
                        <span class="title">商品</span>
                        <?php echo $code=="mall_product" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_goodscate" ? "active open" : "" ?>">
                    <a href="/mall/goodscate" class="nav-link ">
                        <span class="title">分类</span>
                        <?php echo $code=="mall_goodscate" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_order" ? "active open" : "" ?>">
                    <a href="/mall/order" class="nav-link ">
                        <span class="title">订单</span>
                        <?php echo $code=="mall_order" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_cs" ? "active open" : "" ?>">
                    <a href="/mall/cs" class="nav-link ">
                        <span class="title">售后</span>
                        <?php echo $code=="mall_cs" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_freefreight" ? "active open" : "" ?>">
                    <a href="/mall/freefreight" class="nav-link ">
                        <span class="title">运费价格</span>
                        <?php echo $code=="mall_freefreight" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                
                <li class="nav-item <?php echo $code=="mall_tmp" ? "active open" : "" ?>">
                    <a href="/mall/tmp" class="nav-link ">
                        <span class="title">重要说明</span>
                        <?php echo $code=="mall_tmp" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
               <li class="nav-item <?php echo $code=="search" ? "active open" : "" ?>">
                    <a href="/mall/operation/search" class="nav-link ">
                        <span class="title">搜索方案</span>
                        <?php echo $code=="search" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_hot_tags" ? "active open" : "" ?>">
                    <a href="/mall/tags" class="nav-link ">
                        <span class="title">标签</span>
                        <?php echo $code=="mall_hot_tags" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_pre_search" ? "active open" : "" ?>">
                    <a href="/mall/presearch" class="nav-link ">
                        <span class="title">预输入关键字</span>
                        <?php echo $code=="mall_pre_search" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_notice" ? "active open" : "" ?>">
                    <a href="/mall/notice" class="nav-link ">
                        <span class="title">公告</span>
                        <?php echo $code=="mall_notice" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="adware" ? "active open" : "" ?>">
                    <a href="/mall/ware" class="nav-link ">
                        <span class="title">广告库管理</span>
                        <?php echo $code=="adware" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="ad" ? "active open" : "" ?>">
                    <a href="/mall/ad" class="nav-link ">
                        <span class="title">广告管理</span>
                        <?php echo $code=="ad" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="orderpagenotice" ? "active open" : "" ?>">
                    <a href="/mall/orderpagenotice" class="nav-link ">
                        <span class="title">确认订单页面通知</span>
                        <?php echo $code=="orderpagenotice" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="new_ad" ? "active open" : "" ?>">
                    <a href="/mall/operation/new" class="nav-link ">
                        <span class="title">新品广告位</span>
                        <?php echo $code=="new_ad" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                
            </ul>
        </li>
        <?php }?>
        <?php if($mallManage){?>
        <li class="nav-item <?php echo in_array($code,[
"category","attribute","mall_brand","mall_erpstock","mall_kuaidi_tmp","bindingphone","mall_page","supplier_manage","mall_comment",
]) ? "active open" : "" ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <span class="title">管理</span>
                <?php if(in_array($code,[
                    "category","attribute","mall_brand","mall_erpstock","mall_kuaidi_tmp","bindingphone","mall_page","supplier_manage","mall_comment"
                    ])){ ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
                <?php }else{ ?>
                <span class="arrow"></span>
                <?php } ?>
            </a>
            <ul class="sub-menu">
                
               <li class="nav-item <?php echo $code=="supplier_manage" ? "active open" : "" ?>">
                    <a href="/mall/manage/supplier" class="nav-link ">
                        <span class="title">商户管理</span>
                        <?php echo $code=="supplier_manage" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
               <li class="nav-item <?php echo $code=="mall_page" ? "active open" : "" ?>">
                    <a href="/mall/manage/main" class="nav-link ">
                        <span class="title">页面管理</span>
                        <?php echo $code=="mall_page" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
               <li class="nav-item <?php echo $code=="category" ? "active open" : "" ?>">
                    <a href="/mall/category" class="nav-link ">
                        <span class="title">类目</span>
                        <?php echo $code=="category" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="attribute" ? "active open" : "" ?>">
                    <a href="/mall/attribute" class="nav-link ">
                        <span class="title">属性</span>
                        <?php echo $code=="attribute" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_brand" ? "active open" : "" ?>">
                    <a href="/mall/brand" class="nav-link ">
                        <span class="title">品牌</span>
                        <?php echo $code=="mall_brand" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_erpstock" ? "active open" : "" ?>">
                    <a href="/mall/erpstock" class="nav-link ">
                        <span class="title">ERP同步仓库</span>
                        <?php echo $code=="mall_erpstock" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_kuaidi_tmp" ? "active open" : "" ?>">
                    <a href="/mall/kuaiditmp" class="nav-link ">
                        <span class="title">快递模板</span>
                        <?php echo $code=="mall_kuaidi_tmp" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="bindingphone" ? "active open" : "" ?>">
                    <a href="/mall/bindingphone" class="nav-link ">
                        <span class="title">购买手机绑定验证</span>
                        <?php echo $code=="bindingphone" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_comment" ? "active open" : "" ?>">
                    <a href="/mall/manage/comment" class="nav-link ">
                        <span class="title">评价管理</span>
                        <?php echo $code=="mall_comment" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <?php if($mallMarketing){?>
        <li class="nav-item <?php echo in_array($code,[
"mall_coupon","coupon_comment","mall_discount","mall_partner_shop","mall_raider","ad_raider",'gold_bag',"mall_return","special","subtraction"
]) ? "active open" : "" ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <span class="title">营销</span>
                <?php if(in_array($code,[
                    "mall_coupon","coupon_comment","mall_discount","mall_partner_shop","mall_raider","ad_raider","gold_bag","mall_return","special","subtraction"
                    ])){ ?>
                <span class="selected"></span>
                <span class="arrow open"></span>
                <?php }else{ ?>
                <span class="arrow"></span>
                <?php } ?>
            </a>
            <ul class="sub-menu">
               <li class="nav-item <?php echo $code=="mall_coupon" ? "active open" : "" ?>">
                    <a href="/mall/coupon" class="nav-link ">
                        <span class="title">优惠券</span>
                        <?php echo $code=="mall_coupon" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="coupon_comment" ? "active open" : "" ?>">
                    <a href="/mall/couponcomment" class="nav-link ">
                        <span class="title">优惠券评论</span>
                        <?php echo $code=="coupon_comment" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_discount" ? "active open" : "" ?>">
                    <a href="/mall/discount" class="nav-link ">
                        <span class="title">折扣</span>
                        <?php echo $code=="mall_discount" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="/vue/mall/marketing/sales/list" class="nav-link ">
                        <span class="title">限时购</span>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_partner_shop" ? "active open" : "" ?>">
                    <a href="/mall/partnershop" class="nav-link ">
                        <span class="title">拼团</span>
                        <?php echo $code=="mall_partner_shop" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                
                <li class="nav-item <?php echo $code=="mall_raider" ? "active open" : "" ?>">
                    <a href="/mall/raider" class="nav-link ">
                        <span class="title">夺宝</span>
                        <?php echo $code=="" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="ad_raider" ? "active open" : "" ?>">
                    <a href="/mall/raiderad" class="nav-link ">
                        <span class="title">夺宝广告库</span>
                        <?php echo $code=="ad_raider" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="gold_bag" ? "active open" : "" ?>">
                    <a href="/mall/goldbag" class="nav-link ">
                        <span class="title">津币红包</span>
                        <?php echo $code=="gold_bag" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="mall_return" ? "active open" : "" ?>">
                    <a href="/mall/return" class="nav-link ">
                        <span class="title">返还购</span>
                        <?php echo $code=="mall_return" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="special" ? "active open" : "" ?>">
                    <a href="/vue/mall/marketing/special/list" class="nav-link ">
                        <span class="title">专场</span>
                        <?php echo $code=="special" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item <?php echo $code=="subtraction" ? "active open" : "" ?>">
                    <a href="/mall/subtraction" class="nav-link ">
                        <span class="title">满减</span>
                        <?php echo $code=="subtraction" ? '<span class="selected"></span>' : "" ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/vue/mall/marketing/choice/list" class="nav-link ">
                        <span class="title">N元任选</span>
                    </a>
                </li>
                
            </ul>
        </li>
        <?php }?>
        </ul>
    </li>
<?php } ?>