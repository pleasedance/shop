var alert=alert||{};var html='';var shade='';var alertConfig={'min-width':'200px','min-height':'50px','background':'#3690cf','color':'white','position':'middleCenter','z-index':'1000','border-radius':'3%','display':'flex','align-items':'center','justify-content':'center','padding':'10px','box-sizing':'border-box','display':'none'};var alertSetting={'hide':1100};var shadeOption={'width':'100vw','height':'100vh','z-index':'1001','position':'fixed','left':'0','top':'0','display':'none'};var alertDom=$("#proAlertMsg");var shadeDom=$("#proAlertShade");alert={init:function(msg,configs){$.each(configs,function(k,v){alertConfig[k]=v});switch(alertConfig.position){case'middleCenter':alertConfig.position='fixed';alertConfig.left='50%';alertConfig.top='0';alertConfig.transform='translate(-50%, -50%)';break;case'center':alertConfig.position='fixed';alertConfig.left='50%';alertConfig.top='50%';alertConfig.transform='translate(-50%, -50%)';break;case'left':alertConfig.position='fixed';alertConfig.left='0';alertConfig.top='50%';alertConfig.transform='translate(-50%, -50%)';break};html+='<div id="proAlertMsg" style="'+alert.jsonToString(alertConfig)+'">';html+='<span>网络错误</span>';html+='</div>';shade+='<div id="proAlertShade" style="'+alert.jsonToString(shadeOption)+'"></div>';$('body').append(html,shade);alertDom=$("#proAlertMsg");shadeDom=$("#proAlertShade");alert.show(msg,configs)},show:function(msg,configs){if(alertDom.length==0){alert.init(msg,configs)};shadeDom.css({'display':"flex"});switch(configs.position){case'middleCenter':alertDom.stop().animate({'top':'50%'}).css({'display':"flex"}).find('span').html(msg);break;case'center':alertDom.fadeIn(200).css({'display':"flex"}).find('span').html(msg);break;case'left':alertDom.stop().animate({'left':'50%'}).css({'display':"flex"}).find('span').html(msg);break};alert.hide(configs.position)},msg:function(msg,configs={},setting={}){$.each(setting,function(k,v){alertSetting[k]=v});alert.show(msg,configs)},hide:function(position){setTimeout(function(){switch(position){case'middleCenter':alertDom.animate({'top':'0'},500,function(v){alertDom.hide();shadeDom.hide()});break;case'center':alertDom.fadeOut(200);shadeDom.hide();break;case'left':alertDom.animate({'left':'0'},500,function(v){alertDom.hide();shadeDom.hide()});break}},alertSetting.hide)},jsonToString:function(config){var arr=[];$.each(config,function(k,v){arr.push(k+':'+v)});return arr.join(';')},}