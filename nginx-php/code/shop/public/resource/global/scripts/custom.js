var ajaxHttp = function (url, type, data, success, error, unlock) {
    if (!error) {
        var error = function (xhr, statusText) {
            if (xhr.status == "203") {
                swal({
                    title: "会话超时",
                    text: "您还未登录 请先登录",
                    type: "warning"
                }, function () {
                    location.href = "/login";
                })
            } else if (xhr.status != "200") {
                $.bootstrapGrowl(xhr.responseJSON.message, {
                    ele: 'body', // which element to append to
                    type: "danger", // (null, 'info', 'danger', 'success', 'warning')
                    offset: {
                        from: "top",
                        amount: 80
                    }, // 'top', or 'bottom'
                    align: "right", // ('left', 'right', or 'center')
                    width: "auto", // (integer, or 'auto')
                    delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                    allow_dismiss: true, // If true then will display a cross to close the popup.
                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                });
            }
        }
    }


    var callbackError = function (xhr, statusText) {
        if (!unlock) {
            $.unblockUI();
        }
        error(xhr, statusText);
    }


    var callbackSuccess = function (result) {
        if (!unlock) {
            $.unblockUI();
        }
        success(result);
    }

    if (!unlock) {
        $.blockUI({
            message: '<div class="loading-message ' + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>',
            baseZ: 1000,
            css: {
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#555',
                opacity: 0.1,
                cursor: 'wait'
            }
        });
    }
    $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: "json",
        success: callbackSuccess,
        complete: callbackError
    });
}


var ajaxForm = function (dom) {
    ajaxHttp(dom.attr("action"), dom.attr("method"), dom.serializeArray(),
            function (result) {
                if (dom.attr("success-alert") == "false") {
                    dom.trigger("success", result);
                } else {
                    swal({
                        title: "成功",
                        text: "执行完成",
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    })
                    setTimeout(function(){
                        dom.trigger("success", result);
                    },1000)
                }
            }
    );
}

var ajax = function (dom) {
    ajaxHttp(dom.attr("href"), dom.attr("method"), [],
            function (result) {
                if (dom.attr("success-alert") == "false") {
                    dom.trigger("success", result);
                } else {
                    swal({
                        title: "成功",
                        text: "执行完成",
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    })
                    setTimeout(function(){
                        dom.trigger("success", result);
                    },1000)
                }
            }
    );
}

$(".page-content").css("min-height", $(".page-sidebar").height())

$(document).on("click", ".ajax", function () {
    var thisDom = $(this);
    if (thisDom.attr("confirm")) {
        swal({
            title: "确认要这么操作么？",
            text: thisDom.attr("confirm"),
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: "取消",
            confirmButtonText: "确认",
            confirmButtonColor: "#ec6c62"
        },
                function (isConfirm) {
                    if (isConfirm) {
                        ajax(thisDom);
                    }
                    swal.close();
                });
    } else {
        ajax(thisDom);
    }
    return false;
});


$(document).on("submit", ".ajax-form", function () {
    var thisDom = $(this);
	
	if(typeof(pre_submit)=="function"&&!pre_submit()){
		return false;	
	}
    if (thisDom.attr("confirm")) {
        swal({
            title: "确认要提交表单么？",
            text: thisDom.attr("confirm"),
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: "取消",
            confirmButtonText: "确认",
            confirmButtonColor: "#ec6c62"
        },
                function (isConfirm) {
                    if (isConfirm) {
                        ajaxForm(thisDom);
                    }
                    swal.close();
                });
    } else {
        ajaxForm(thisDom);
    }
    return false;
});

// 表单js
var handleInput = function (el) {
    if (el.val() != "") {
        el.addClass('edited');
    } else {
        el.removeClass('edited');
    }
}

$('body').on('keydown', '.form-md-floating-label .form-control', function (e) {
    handleInput($(this));
});
$('body').on('blur', '.form-md-floating-label .form-control', function (e) {
    handleInput($(this));
});



var showImg = function (url,w,h,crop){
    if(!url){
        return "/resource/now/apps/img/no_image.png"
    }
    var query="";
    if(w){
        query+=w+"w";
    }
    if(h){
        if(query){
            query+="_";
        }
        query+=h+"h";
    }
    if(crop){
        if(query){
            query+="_";
        }
        query+="1e_1c";
    }
    if(query){
        url+="@"+query;
    }
    return url;
}

var commit = {
    xhr:false,             //请求标识
    isClose:false,      //是否已结束 用来判断是否会再次发起请求
    sendData:{},
    init:function(url,method,timeout,callbackSuccess){
        if(this.isClose){
            return ;
        }
        var _this=this;
        this.xhr=$.ajax({
            url: url,
            timeout:timeout,
            type: method,
            data: this.sendData,
            dataType: "json",
            success: callbackSuccess,
            complete: function(){
                _this.init(url,method,timeout,callbackSuccess);
            }
        });
        return this;
    },
    setParam:function(k,v){
        this.sendData[k]=v;
        return this;
    },
    close:function(){
        this.isClose=true;
        if(this.xhr){
            this.xhr.abort();
        }
    }
};


var heartbeat = function(code,cd){
    var sendHeartBeat=function(){
        $.ajax({
            url: "/heartbeat",
            type: "POST",
            data: {code:code}
        });
    }
    sendHeartBeat();
    window.setInterval(function(){
        sendHeartBeat();
    }, cd*1000);
}