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
<?php echo View::make('common/menu', ["code" => "order"]); ?>
<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h1 class="page-title"> 订单管理
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
                        <a href="javascript:;">订单管理</a>
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
                                                    <th class="col-md-2"> 订单编号 </th>
                                                    <th class="col-md-2"> 下单用户 </th>
                                                    <th class="col-md-1"> 订单创建时间 </th>
                                                    <th class="col-md-1"> 订单支付时间 </th>
                                                    <th class="col-md-1"> 订单发货时间 </th>
                                                    <th class="col-md-1"> 订单完成时间 </th>
                                                    <th class="col-md-1"> 收货地址 </th>
                                                    <th class="col-md-1"> 收货人姓名 </th>
                                                    <th class="col-md-1"> 收货人手机号 </th>
                                                    <th class="col-md-1"> 快递单号 </th>
                                                    <th class="col-md-1"> 快递公司名称 </th>
                                                    <th class="col-md-1"> 支付金额 </th>
                                                    <th class="col-md-1"> 运费金额 </th>
                                                    <th class="col-md-1"> 退货金额 </th>
                                                    <th class="col-md-1"> 支付方式 </th>
                                                    <th class="col-md-1"> 订单状态 </th>
                                                    <th class="col-md-1"> 物流状态 </th>
                                                    <th class="col-md-1"> 支付状态 </th>
                                                    <th class="col-md-1"> 收货状态 </th>
                                                    <th class="col-md-1"> 评价状态 </th>
                                                    <th class="col-md-1"> 退款状态 </th>
                                                    <th class="col-md-1"> 退货状态 </th>
                                                    <th class="col-md-2"> 操作 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($list as $value) { ?>
                                                <tr>
                                                    <td><?php echo $value->order_sub_sn; ?></td>
                                                    <td><?php echo $value->buyer->real_name; ?></td>
                                                    <td><?php echo $value->created_at; ?></td>
                                                    <td><?php echo $value->payment_time; ?></td>
                                                    <td><?php echo $value->shipping_time; ?></td>
                                                    <td><?php echo $value->complete_time; ?></td>
                                                    <td><?php echo $value->receive_province.$value->receive_city.$value->receive_area.$value->receive_address; ?></td>
                                                    <td><?php echo $value->receive_name; ?></td>
                                                    <td><?php echo $value->receive_phone; ?></td>
                                                    <td><?php echo $value->shipping_sn; ?></td>
                                                    <td><?php echo $value->shipping_comp_name; ?></td>
                                                    <td><?php echo $value->payment_money; ?></td>
                                                    <td><?php echo $value->shipping_money; ?></td>
                                                    <td><?php echo $value->return_goods_money; ?></td>
                                                    <td><?php echo $value->payment_method?"余额支付":"微信支付"; ?></td>
                                                    <td><?php echo $value->order_status?"有效":"无效"; ?></td>
                                                    <td><?php echo $value->send_status?"已发货":"未发货"; ?></td>
                                                    <td><?php echo $value->pay_status?"已支付":"未支付"; ?></td>
                                                    <td><?php echo $value->receipt_status?"已收货":"未收货"; ?></td>
                                                    <td><?php echo $value->evaluation_status?"已评价":"未评价"; ?></td>
                                                    <td><?php echo $value->refund_status?"已退款":"未退款"; ?></td>
                                                    <td><?php echo $value->return_goods_status?"已退货":"未退货"; ?></td>
                                                    <td><?php echo $value->pay_sn; ?></td>
                                                    <td>
                                                        <?php
                                                        if (!$value->receipt_status){
                                                            //echo "<a class='btn btn-circle' onclick='receipt(\"".$value->order_sub_sn."\")'>买家收货</a>";
                                                        }
                                                        if (!$value->send_status){
                                                            echo "<a class='btn btn-circle' onclick='send(\"".$value->order_sub_sn."\")'>发货</a>";
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

            window.receipt = function(sn){
                $.ajax({
                    type: "PUT",
                    url: "/selleradmin/order/receipt/"+sn,
                    data: {},
                    dataType: "json",
                    success: function(data){
                        location.reload(true);
                    },
                    error: function (e) {

                    }
                });
            };

            window.send = function(sn){
                <?php
                    $logistics = config("logistics");
                    $select = "<select name='shipping_comp_name' class='form-control input-inline input-medium shipping_comp_name'>";
                    $select .= "<option value=''>未选择运费快递公司</option>";
                    foreach ($logistics as $k=>$v){
                        $select .= "<option value='".$k."'>".$v."</option>";
                    }
                    $select .= "</select>";
                ?>
              var model=$("<div><div class='leabl'><span>快递公司</span><?php echo $select;?></div><div class='leabl'><span>快递单号</span><input class='shipping_sn' /></div></div>").css({
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
                      url: "/selleradmin/order/send/"+sn,
                      data: {
                          shipping_sn:$(".shipping_sn").val(),
                          shipping_comp_name:$(".shipping_comp_name option:selected").text(),
                          shipping_comp_code:$(".shipping_comp_name").val()
                      },
                      dataType: "json",
                      success: function(data){
                          // console.log(data);
                          location.reload(true);
                      },
                      error: function (a, b, c) {
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