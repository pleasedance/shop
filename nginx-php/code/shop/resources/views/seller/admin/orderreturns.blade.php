<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 2.3.1
Version: 1.3
Author: KeenThemes
Website: http://www.keenthemes.com/preview/?theme=metronic
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469
-->
<!--[if IE 8]> <html lang="zh-CN" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh-CN" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="zh-CN" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php echo View::make('common/header'); ?>
   <style>
       .leabl{
          padding: 15px 0;
       }
       .leabl input{
           width: 300px;
           height: 40px;
           margin-left: 30px;
       }
       .leabl textarea{
           width: 300px;
           height: 200px;
           margin-left: 30px;
       }
       .div_flex{
           display: flex;
       }
   </style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN HEADER -->
<?php echo View::make('common/top'); ?>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
<?php echo View::make('common/menu', ["code" => "order/returns"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 退货订单
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/selleradmin">商家订单</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-user"></i>
                        <a href="javascript:;">退货订单</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet light portlet-fit ">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-list"></i>
                                <span class="caption-subject bold uppercase">订单管理</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet-body">
                                        <div class="table">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-2"> 退货单编号 </th>
                                                    <th class="col-md-2"> 下单用户 </th>
                                                    <th class="col-md-1"> 子订单编号 </th>
                                                    <th class="col-md-1"> 退货状态 </th>
                                                    <th class="col-md-1"> 商家收货地址 </th>
                                                    <th class="col-md-1"> 退货运费金额 </th>
                                                    <th class="col-md-1"> 退货快递单号 </th>
                                                    <th class="col-md-1"> 退货快递公司名称 </th>
                                                    <th class="col-md-1"> 商品唯一code </th>
                                                    <th class="col-md-1"> 购买数量 </th>
                                                    <th class="col-md-1"> 商品单价 </th>
                                                    <th class="col-md-1"> 实际支付金额 </th>
                                                    <th class="col-md-1"> 退货原因 </th>
                                                    <th class="col-md-1"> 退货描述 </th>
                                                    {{--<th class="col-md-1"> 退货图片 </th>--}}
                                                    <th class="col-md-1"> 拒绝理由 </th>
                                                    <th class="col-md-1"> 创建时间 </th>
                                                    <th class="col-md-2"> 操作 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($list as $value) { ?>
                                                <tr>
                                                    <td><?php echo $value->order_return_sn; ?></td>
                                                    <td><?php echo $value->buyer->real_name; ?></td>
                                                    <td><?php echo $value->order_sub_sn; ?></td>
                                                    <td><?php
                                                        switch ($value->return_goods_status){
                                                            case "0":
                                                                echo "退货中";
                                                                break;
                                                            case "1":
                                                                echo "已退货";
                                                                break;
                                                            case "2":
                                                                echo "拒绝";
                                                                break;
                                                            case "3":
                                                                echo "申请中";
                                                                break;
                                                        }
                                                         ?></td>
                                                    <td><?php echo $address->province.$address->city.$address->area.$address->receive_address; ?></td>
                                                    <td><?php echo $value->freight_money; ?></td>
                                                    <td><?php echo $value->shipping_sn; ?></td>
                                                    <td><?php echo $value->shipping_comp_name; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->product_number; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->product_cnt; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->product_money; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->payment_money; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->return_goods_reason; ?></td>
                                                    <td><?php echo $value->orderReturnsDetail->return_goods_desr; ?></td>
                                                    <!--<td><?php
                                                            /*
                                                        $imgArr = explode(",",$value->orderReturnsDetail->return_goods_img);
                                                        if (!empty($imgArr)){
                                                            foreach ($imgArr as $v){
                                                                echo '<img src="'.$v.'" alt="">';
                                                            }
                                                        }
                                                        ; */?></td>-->
                                                    <td><?php echo $value->refuse_reason; ?></td>
                                                    <td><?php echo $value->created_at; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($value->return_goods_status == 3){
                                                            echo "<a class='btn btn-circle' onclick='agree(\"".$value->order_sub_sn."\")'>同意</a>";
                                                            echo "<a class='btn btn-circle' onclick='refuse(\"".$value->order_sub_sn."\")'>拒绝</a>";
                                                        }
                                                        if ($value->return_goods_status == 0){
                                                            echo "<a class='btn btn-circle' onclick='confirm(\"".$value->order_sub_sn."\")'>确认退货</a>";
                                                        }
                                                        if ($value->return_goods_status == 1 && $value->refund_status == 0){
                                                            echo "<a class='btn btn-circle' onclick='refund(\"".$value->order_sub_sn."\")'>退款</a>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="page"><?php echo $list->links() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
    </div>
    <!-- BEGIN FOOTER -->
<?php echo View::make('common/footer'); ?>
<!-- END FOOTER -->
<?php echo View::make('common/corejs'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/resource/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function () {
            $('body').on("success", ".ajax", function () {
                location.reload();
            });

            //同意申请
            window.agree = function(sn){
                $.ajax({
                    type: "PUT",
                    url: "/selleradmin/order/agree/"+sn,
                    data: {},
                    dataType: "json",
                    success: function(data){
                        if (data.id){
                            location.reload(true);
                        }
                    },
                    error: function (a) {
                        alert(a.responseJSON.message);
                    }
                });
            };

            //拒绝申请
            window.refuse = function(sn){
                var model=$("<div><div class='leabl div_flex'><span>拒绝理由</span><textarea id='refuse_reason'></textarea></div>" +
                    "</div>").css({
                    "width":"500px",
                    "background":"#fff",
                    "position": "fixed",
                    "top": "50%",
                    "left": "calc(50% - 250px)",
                    "display": "flex",
                    "z-index":201,
                    "flex-direction": "column",
                    'padding': '30px'
                });
                var blank=$("<div></div>").css({
                    "position":"fixed",
                    "width":"100%",
                    "height":"100%",
                    "left":"0",
                    "top":"0",
                    "z-index":200,
                    "background": "rgba(0,0,0,0.5)",

                }).on("click",function () {
                    model.remove();
                    blank.remove()
                });
                var btn=$("<input type='button' value='确定'>").css({
                    'background': '#17C4BB',
                    'border': 'none',
                    'width': '200px',
                    'align-self': 'center',
                    'height': '40px',
                    'color': '#fff'
                }).on("click",function () {
                    $.ajax({
                        type: "PUT",
                        url: "/selleradmin/order/refuse/"+sn,
                        data: {refuse_reason:$("#refuse_reason").val()},
                        dataType: "json",
                        success: function(data){
                            if (data.id){
                                // model.remove();
                                // blank.remove()
                                location.reload(true);
                            }
                        },
                        error: function (a) {
                            alert(a.responseJSON.message);
                        }
                    });
                    // model.remove();
                    // blank.remove()
                });
                btn.appendTo(model);
                blank.appendTo($("body"));
                model.appendTo($("body"));
            };

            //确认收货
            window.confirm = function(sn){
                $.ajax({
                    type: "PUT",
                    url: "/selleradmin/order/confirm/"+sn,
                    data: {},
                    dataType: "json",
                    success: function(data){
                        if (data.id){
                            location.reload(true);
                        }
                    },
                    error: function (a) {
                        alert(a.responseJSON.message);
                    }
                });
            };

            //退款
            window.refund = function(sn){
                var money=prompt("请输入退款金额（不允许大于实际支付金额）！","");
                if (money!=null && money!="")
                {
                    $.ajax({
                        type: "PUT",
                        url: "/selleradmin/order/refund/"+sn,
                        data: {money:money},
                        dataType: "json",
                        success: function(data){
                            if (data.id){
                                location.reload(true);
                            }
                        },
                        error: function (a) {
                            alert(a.responseJSON.message);
                        }
                    });
                }
            };

            $("body").on("click",".assign",function(){
                var id=$(this).attr("data-id");
                var html='<div class="row"><div class="form-body"><div class="form-group">'+
                    '<label class="col-md-3 control-label">分配流量<span class="required" aria-required="true"> * </span></label>'+
                    '<div class="col-md-9"><input type="number" name="num" class="form-control input-medium"></div>'+
                    '</div></div></div>'
                bootbox.dialog({
                    title: "分配流量",
                    message: html,
                    buttons: {
                        success: {
                            label: "分配",
                            className: "green",
                            callback: function() {
                                ajaxHttp("/company/assign","post",{id:id,num:$("input[name=num]").val()},function(){
                                    swal({
                                        title: "成功",
                                        text: "执行完成",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    })
                                    setTimeout(function(){
                                        location.reload();
                                    },1000)
                                });
                                return false;
                            }
                        },
                        main: {
                            label: "取消",
                            className: "blue",
                            callback: function() {
                                return true;
                            }
                        }
                    }
                });
                return false;
            })


        });
    </script>
    <!-- END JAVASCRIPTS -->
    <!-- END BODY -->
</body>
</html>