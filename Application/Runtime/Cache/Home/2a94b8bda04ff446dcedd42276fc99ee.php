<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
    <title>猜骰子</title>

    <link rel="stylesheet" href="/res/touzi/base.css">
    <link rel="stylesheet" href="/res/touzi/layer.css">
    <link rel="stylesheet" href="/res/touzi/layer2.css">
    <link rel="stylesheet" href="/res/touzi/style.css">
    <link rel="stylesheet" href="/res/touzi/weui.css">
    <style>

        .close-play{
            position: absolute;
            bottom: 10px;
            left: 35%;
            padding: 0px 40px;
            font-size: 13px;
            background-image: linear-gradient(307deg, #347189, #55784e);
        }

        .bigAndSmall{
            display: inline-block;
            text-decoration: none;
            color: #E4C468;

            border-radius: 5px;
            width: 100%;
        }
        .top-a{
            text-decoration: none;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 10px 10px;
            font-size: 12px;
            display: inline-block;
            margin-top: -20px;
            letter-spacing: 1px;
            background-color: rgba(61, 52, 89, 0.3);
            box-shadow: 0 0 5px 0 rgba(61, 52, 89, 0.3);
        }
        .wrap-a-bigAndSmall{
            text-align: center;
            width: 100%;
            font-size: 18px;
            margin: 8px;
            background-color: #999;
            background-image: -webkit-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
            background-image:    -moz-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
            background-image:     -ms-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
            background-image:      -o-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
            background-image:         linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
            border: none;
            border-radius: .5em;
            box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.2),
            inset 0 2px 0 hsla(0,0%,100%,.1),
            inset 0 1.2em 0 hsla(0,0%,100%,0.1),
            inset 0 -.2em 0 hsla(0,0%,100%,.1),
            inset 0 -.25em 0 hsla(0,0%,0%,.25),
            0 .25em .25em hsla(0,0%,0%,.05);
            color: #444;
            cursor: pointer;
            display: inline-block;
            font-family: sans-serif;
            font-size: 1em;
            font-weight: bold;
            line-height: 1.5;
            margin: 0 .5em 1em;
            padding: 40px 0;
            position: relative;
            text-decoration: none;
            text-shadow: 0 1px 1px hsla(0,0%,100%,.25);
            vertical-align: middle;
            background-image: radial-gradient(circle at 60% 48%, #3D3459, #10112F);
            color: #fff;
            font-weight: bold;
        }

        .wrap-a-span{
            font-weight: bold;
            font-size:30px;
            text-align: center;
            color: #E4C468;
        }


        .jetton-img{ width: 100px; height: 100px; cursor: pointer;}

        .weui-flex__item{
            margin-bottom: 10px;
        }
        /*文字滚动样式*/
        .sliderbox{position:relative;}/*必须加这句css,否则向左右，上下滚动时会没有效果*/
        .text{  height: 30px;  width: 320px;  overflow: hidden;  margin: 0 auto;  position: absolute;  z-index: 999;  top: 17px;  left: 45px;   color: #E4C468;  }
        .text li{line-height:30px; height: 30px; width: 330px; white-space: nowrap; overflow: hidden; text-overflow:ellipsis;}
        .text li a{  color: #E4C468;}

        @media screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2){
            .wrap-a-bigAndSmall{font-size: 18px;}
            .top-a{    margin-top: -30px;  margin-bottom: -7px;}
        }

        @media screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2){
            .weui-flex__item{
                margin: 6px;
            }
        }
        @media screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3){
            .weui-flex__item{
                margin: 4px;
            }
            .text{left:50px; top:20px;}
        }


        /*支付方式 微信 ---- 余额 样式*/
        .mgr {  position: relative;  width: 16px;  height: 16px;  background-clip: border-box;  -webkit-appearance: none;  -moz-appearance: none;  appearance: none;  margin: -.15px .6px 0 0;
            vertical-align: text-bottom;  border-radius: 50%;  background-color: #fff;  border: 1px solid #d7d7d7;  }
        .mgr-danger {  background-color: #fff;  border: 1px solid #d7d7d7;  }
        .mgr-lg {  width: 19px;  height: 19px;  }
        .mgr-danger:checked {  border: 1px solid #cf3b3a;  }
        .mgr:checked {  border: 1px solid #555;  }
        .mgr-lg:checked:before {  height: 11px;  width: 11px;  border-radius: 50%;  margin: 3px 0 0 3px;  }
        .mgr-danger:checked:before {  background-color: #cf3b3a;  }
        .mgr:checked:before {  height: 10px;  width: 10px;  border-radius: 50%;  margin: 3px 0 0 3px;  }
        .mgr:before {  content: '';  display: block;  height: 0;  width: 0;  -webkit-transition: width .25s,height .25s;  transition: width .25s,height .25s;  }
        .pay{ text-align: center;  margin: 19px;  color: #fff;  font-size: 14px;}

        .fontSize{ color: #fff; font-size: 15px; display: block;  margin-top: -5px; }


        .topInfo{
            text-align: center;
            background-image: radial-gradient(circle at 60% 48%, #3D3459, #10112F);
            margin: 5px 0;
            color: #fff;
            letter-spacing: 1px;
            box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.2),
            inset 0 2px 0 hsla(0,0%,100%,.1),
            inset 0 1.2em 0 hsla(0,0%,100%,0.1),
            inset 0 -.2em 0 hsla(0,0%,100%,.1),
            inset 0 -.2em 0 hsla(0,0%,0%,.25),
            0 .25em .2em hsla(0,0%,0%,.05);
        }

        /*缩放效果*/
        .scaleTips{
            -webkit-animation: open 0.2s linear 0.5s infinite alternate;
            -webkit-animation-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
            animation: open 0.2s linear 0.5s infinite alternate;
            animation-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
            color:#E4C468;
            font-size: 13px;
            transition: all 0.2s ease-in-out;
        }
        @keyframes open { 0% {  transform: scale(1);  } 100% {  transform: scale(0.9);  } }
        @-webkit-keyframes open { 0% {  -webkit-transform: scale(1);  } 100% {  -webkit-transform: scale(0.9);  } }
        @-ms-keyframes open { 0% {  -webkit-transform: scale(1);  } 100% {  -webkit-transform: scale(0.9);  } }
        @-moz-keyframes open { 0% {  -webkit-transform: scale(1);  } 100% {  -webkit-transform: scale(0.9);  } }
        @-o-keyframes open { 0% {  -webkit-transform: scale(1);  } 100% {  -webkit-transform: scale(0.9);  } }

        .getKjHb-div{
            background: url(/Public/Home/images/hongbao/alertHb.png) no-repeat;
            background-size: contain;
            width: 345px;
            height: 380px;
        }
        .getKjHb-a{
            width: 60%;
            border: 1px solid #fff;
            color: #E4C468;
            font-size: 20px;
            font-weight: 700;
            position: relative;
            bottom: -200px;
        }
        .getKjHb-p{
            position: relative;
            top: 85px;
            color: #E4C468;
            font-size: 25px;
            text-align: center;
        }
        .text{
            z-index: 10;
        }
        .text li,.text{
            width: 100%;
            left: 0;
            text-align: center;
        }
    </style>
<meta name="poweredby" content="htewl.com" />
</head>
<body style="background-color:#250A00;">
<!-- background-image: radial-gradient(circle, #bc40fe, #22291d); -->
<header style=" background: url(/res/touzi/bg.jpg) no-repeat; background-size: cover;">
  <a href="javascript:;" id="getAward" class="top-a " style="position:absolute; top: 80px; left: 20px;">领取连赢红包</a>
    <div class="weui-flex topInfo">
        <div class="weui-flex__item" style=" border-right: 1px solid rgba(153, 153, 153, 0.38);">
            <p>距离开奖时间</p>
            <p id="second_show" style="color:#FFC107;"><span id="miao">00</span>秒</p>
        </div>

        <div class="weui-flex__item">
            <p>上期开奖结果</p>
            <p id="kjResult" style="color:#FFC107;">第<?php echo ($lilist["id"]); ?>期:<?php echo ($lilist["isid"]); ?>点,<?php if($lilist['isid']<=3){ echo '小';}else{ echo '大';}?></p>
        </div>
    </div>

    <!--<a href='/User/back.html' class='top-a' style="position:absolute; top: 90px; right: 25px;">收藏游戏</a>-->
    <div class="weui-flex" style="background: url() no-repeat center; background-size: contain;">
        <div class="weui-flex__item" style="margin: 10px auto;">
            <div class="wrap">
                <div class="dice dice_<?php echo ($lilist["isid"]); ?>" style="cursor: pointer;"></div>
            </div>
        </div>
    </div>

    <div class="weui-flex" style="text-align: center;margin-top: 15px;">
        <div class="weui-flex__item"> <a href="/index.php?m=&c=Index&a=lishi" id="history" class="top-a">历史记录</a></div>
        <div class="weui-flex__item">
            <div class="top-a">
                <div style="color:#fff">本次压注：<span class="type" id="show_number" style="color:#FFF201"> <?php if($mybuy['buyid']){ if($mybuy['buyid']<=6){echo $mybuy['buyid'] ;}elseif($mybuy['buyid']==7){ echo '大';}else{ echo '小';} }else{ echo '无';}?>  </span></div>
                <div style="color:#fff">筹码数：<span class="chouMaNum" id="show_money" style="color:#FFF201"><?php if($mybuy['money']){ echo $mybuy['money']; }else{ echo '0';}?></span></div>
            </div>
        </div>
        <div class="weui-flex__item"><span id="tips" class="top-a" onclick="shuoming();">游戏说明</span></div>
    </div>



</header>
<div class="layui-layer layui-layer-dialog layer-anim" id="layui-layer1" type="dialog" times="1" showtime="0" contype="string" style="z-index: 19891015; top: 213px; left: 50px;display: none;border-radius:10px;"><div class="layui-layer-title" style="cursor: move;">信息</div><div id="" class="layui-layer-content layui-layer-padding"></div><span class="layui-layer-setwin"><a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" style="font-size: 26px;margin-top: -10px" onclick="queding()">x</a></span><div class="layui-layer-btn layui-layer-btn-"><a class="layui-layer-btn0" onclick="queding()">确定</a></div><span class="layui-layer-resize"></span></div>

<img src="/res/touzi/457684782019572638.jpg" style="width: 90%;max-width: 400px;left:5%;top: 70px;display: none;position: fixed;z-index: 999;" class="shuoming" onclick="guanming()">
<section style="background-color:#250A00; height: auto; margin-bottom: 50px; position: relative;">
    <figure><img src="/res/touzi/tree.png" style="width: 100%;"></figure>
    <div class="content">
        <div class="text" id="text-slideTo">
            <ul class="sliderbox">
                <li class="current" style="z-index: 2;"><a href="javascript:;">公告：请收藏游戏推广二维码，方便下次找到游戏入口</a></li>

            </ul>
        </div>
    </div>
    <div class="weui-flex">
        <div class="weui-flex__item wrap-a-bigAndSmall"><span onclick="select_num(7)" class="bigAndSmall" id="big" data-num="1"><span class="wrap-a-span">大</span><br><span class="fontSize">1赔1.9</span></span></div>
        <div class="weui-flex__item wrap-a-bigAndSmall"><span onclick="select_num(8)" class="bigAndSmall" id="small" data-num="1"><span class="wrap-a-span">小</span><br><span class="fontSize">1赔1.9</span></span></div>
    </div>
    <div class="forms">
        <div class="weui-flex">
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(1)" > <span class="wrap-a-span">1</span><br /><span class="fontSize">1赔5</span></span></div>
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(2)"> <span class="wrap-a-span">2</span><br /><span class="fontSize">1赔5</span></span></div>
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(3)"> <span class="wrap-a-span">3</span><br /><span class="fontSize">1赔5</span></span></div>
        </div>
        <div class="weui-flex">
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(4)"> <span class="wrap-a-span">4</span><br /><span class="fontSize">1赔5</span></span></div>
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(5)"> <span class="wrap-a-span">5</span><br /><span class="fontSize">1赔5</span></span></div>
            <div class="weui-flex__item wrap-a-bigAndSmall" onclick="select_num(6)"> <span class="wrap-a-span">6</span><br /><span class="fontSize">1赔5</span></span></div>
        </div>
    </div>
</section>

<!--<footer id="bar-dice-bottom">
    <ul class="Grid dice-box -middle -center" style="flex-wrap:nowrap; -webkit-flex-wrap: nowrap;">
    <li class="Cell"><a href="/HongBao/index.html" role="tab"><i class="hb-icond"></i>抢红包</a></li>
        <li class="Cell current"><a href="/Index/index.html" role="tab"><i class="dice-icon-2"></i>骰子游戏</a></li>
        <li class="Cell"><a href="/User/myqrCode.html" role="tab"><i class="myShare-icon-1"></i>我要分享</a></li>
        <li class="Cell"><a href="/User/index.html" role="tab"><i class="personCenter-icon-1"></i>个人中心</a></li>
    </ul>
</footer>-->
<nav >
    <div class="weui-tabbar">
        <!-- <a href="/Ssc/index.html" class="weui-tabbar__item">
            <i class="my-bet-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">时时彩</p>
        </a> -->

        <a href="/" class="weui-tabbar__item">
            <i class="dice-icon-2 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">猜大小</p>
        </a>
        <a href="/index.php?m=&c=Index&a=usercode" class="weui-tabbar__item">
            <i class="myShare-icon-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">分享赚钱</p>
        </a>
        <a href="/index.php?m=&c=Index&a=ucenter" class="weui-tabbar__item">
            <i class="personCenter-icon-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">个人中心</p>
        </a>
    </div>
</nav>



<div id="buy" style="display: none;">
<div class="layui-layer-shade" id="layui-layer-shade1" times="1" style="z-index:19891014; background-color:rgba(0, 0, 0, 0.2); opacity:0.9; filter:alpha(opacity=90);display: none;"></div><div class="layui-layer layui-layer-page yourclass layer-anim" id="layui-layer1" type="page" times="1" showtime="0" contype="string" style="z-index: 19891015; top: 0px; left: 0px;border-radius:10px;"><div id="" class="layui-layer-content"><div style=" background-color:rgba(0, 0, 0, 0.59);border-radius: 10px;"> <div class="weui-flex" id="img" style=""><div class="weui-flex__item" onclick="buy_goods(10)"><a href="javascript:void(0);" data-num="5"><img src="/res/touzi/jetton-10.png" data-num="10" class="jetton-img"></a></div><div class="weui-flex__item" onclick="buy_goods(20)"><a href="javascript:void(0);" data-num="10"><img src="/res/touzi/jetton-20.png" data-num="20" class="jetton-img"></a></div><div class="weui-flex__item" onclick="buy_goods(50)"><a href="javascript:void(0);" data-num="20"><img src="/res/touzi/jetton-50.png" data-num="50" class="jetton-img"></a></div></div><div class="weui-flex"><div class="weui-flex__item" onclick="buy_goods(100)"><a href="javascript:void(0);" data-num="50"><img src="/res/touzi/jetton-100.png" data-num="100" class="jetton-img"></a></div><div class="weui-flex__item" onclick="buy_goods(150)"><a href="javascript:void(0);" data-num="150"><img src="/res/touzi/jetton-150.png" data-num="150" class="jetton-img"></a></div><div class="weui-flex__item" onclick="buy_goods(200)"><a href="javascript:void(0);" data-num="200"><img src="/res/touzi/jetton-200.png" data-num="200" class="jetton-img"></a></div></div><div class="weui-flex"><div class="weui-flex__item" onclick="buy_goods(500)"><a href="javascript:void(0);" data-num="500"><img src="/res/touzi/jetton-500.png" data-num="500" class="jetton-img"></a></div><div class="weui-flex__item" onclick="buy_goods(1000)"><a href="javascript:void(0);" data-num="1000"><img src="/res/touzi/jetton-1000.png" data-num="1000" class="jetton-img"></a></div><div class="weui-flex__item"></div></div><p style="text-align: center; color: #fff; font-size: 15px;">本次押注：<span id="ya">大</span></p><div class="pay"><span>支付方式：</span><!--<input type="radio" name="pay" class="mgr mgr-danger mgr-lg" value="1" onclick="buytype(1)"> 微信&nbsp;&nbsp;&nbsp;--><input onclick="buytype(2)" checked type="radio" name="pay" class="mgr mgr-danger mgr-lg" value="2"> 账户余额 </div><div style="text-align: center;  padding: 10px 0;"><a href="javascript:void(0);" class="weui-btn weui-btn_mini weui-btn_primary">请选择下注金额</a>&nbsp;<a href="javascript:hideshow();" class="weui-btn weui-btn_mini weui-btn_primary">关闭</a> </div> </div></div><span class="layui-layer-setwin"></span><span class="layui-layer-resize"></span></div><div class="layui-layer-move"></div>


</div>
<input value="0" class="ispay" type="hidden"/>
<input value="0" class="yanum" type="hidden"/>
<input value="2" class="buytype" type="hidden"/>
<script type="text/javascript" src="/Public/js/jquery-1.7.2-min.js"></script>
<script src="https://cdn.bootcss.com/layer/3.0.1/layer.min.js"></script>
	<script>


	// 唤起微信支付


	function call_pay(param,url,id){


		param = eval('('+param+')');


		if(typeof url == 'undefined' || !url)url = location.href;


		if (typeof WeixinJSBridge == "undefined"){


			if( document.addEventListener ){


				document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);


			}else if (document.attachEvent){


				document.attachEvent('WeixinJSBridgeReady', jsApiCall); 


				document.attachEvent('onWeixinJSBridgeReady', jsApiCall);


			}





		}else{


			WeixinJSBridge.invoke(


				'getBrandWCPayRequest',


				param,


				function(res){


					WeixinJSBridge.log(res.err_msg);


					if(res.err_msg == 'get_brand_wcpay_request:cancle'){


						alert('你取消了支付');


						location.href = '';


					}else if(res.err_msg == 'get_brand_wcpay_request:ok'){

						//alert('支付成功');


			        	location.href = '/';


					}else{


						alert(res.err_msg)


						location.href = url;


					}


					


					


				}


			);


		}


	}


	function  jsApiCall(){


        WeixinJSBridge.invoke(


				'getBrandWCPayRequest',


				{


                   "appId" : "<?php echo $param['appId']?>",     //公众号名称，由商户传入     


                   "timeStamp":"<?php echo $param['timeStamp']?>",         //时间戳，自1970年以来的秒数     


                   "nonceStr" : "<?php echo $param['nonceStr']?>", //随机串     


                   "package" : "<?php echo $param['package']?>",     


                   "signType" : "MD5",         //微信签名方式:     


                   "paySign" : "<?php echo $param['paySign']?>" //微信签名 


               },


				function(res){


					WeixinJSBridge.log(res.err_msg);


					if(res.err_msg == 'get_brand_wcpay_request:cancle'){


						alert('你取消了支付');


						location.href = url;


					}else if(res.err_msg == 'get_brand_wcpay_request:ok'){


						//alert('支付成功');


				        	location.href = '/';


					}else{


						alert(res.err_msg)


						location.href = url;


					}


					


					


				}


			);


	}


	function clickPlantB(plant_id){


		<!--点击播种-->


		$.post("<?php echo U('do_plant');?>",{plant_id:plant_id,index:<?php echo ((isset($_GET['index']) && ($_GET['index'] !== ""))?($_GET['index']):0); ?>},function(d){


			layer.msg(d.info);


			// if(d.status == 1){


			// 	location.href = location.href;


			// }


		});


	}


	// 通用ajax表单提交


	function ajaxFormSubmit(seletor){


		if(!seletor || seletor == '')seletor = "form";


		data = $(seletor).serialize();


		layer.load(0, {shade: [0.1,'#fff']});


		$.post($(seletor).attr('action'),data,function(data){


			layer.closeAll();


			_index = layer.msg(data.info);


			if(data.url && data.url != ''){


				// 延迟一秒钟跳转


				setTimeout(function(){


					location.href = data.url;


				},1000)


			}


			else{


				setTimeout(function(){


					layer.close(_index);


				},3000)


			}


		})


	}


	


	layer.loading = function(param){


		layer.load(0, {shade: false});


		//var par =$.extend({},{type: 2,shadeClose:false},param);


		//layer.open(par)


	}


	</script>



<script type="text/javascript">
  function buy_goods(money){
     var ispay = $(".ispay").val();
     if(ispay == 0){
         $(".ispay").val(1);
         var yanum = $(".yanum").val();
         var buytype =  $(".buytype").val();
	     $.post("/index.php?m=&c=Index&a=cai",{money:money,yanum:yanum,buytype:buytype},function(d){
	      $(".ispay").val(0);
	      if(d.status==1){	      	
	      	 if(buytype==1){
	      	  call_pay(d.pay_param,'','');
	      	 }else{
             alert(d.info);
             location.href="/";	  
	      	}
	      	}else{
	      	 alert(d.info);	
	      	}
	     
	     });
     }
	}
  function buytype(id){
    $(".buytype").val(id);
  }	
  function select_num(num){
  	$('.yanum').val(num);
  	if(num<=6){
  		$("#ya").html(num+'点');
  	}
  	if(num==7){
  		$("#ya").html('大');
  	}
  	if(num==8){
  		$("#ya").html('小');
  	}
    $("#buy").show();
  }
  function select_daxiao(type){
    $("#buy").show();
  }
  function queding(){
     $("#layui-layer").hide();
     location.href="/";
  }
  function shuoming(){
  	$(".shuoming").show();
  }
  function guanming(){
  	$(".shuoming").hide();
  }
  var wait= <?php echo ($miao); ?>;
  time();
  function time() {
    if (wait == 0) {
      setTimeout(function() {
        jieshu();
      },
      2000);
      $("#second_show").html('正在开奖中...');
    } else {
      wait--;
      var miao = wait;
      if(wait<10){
         miao ='0' + wait; 
      }
      $('#miao').html(miao);
      setTimeout(function() {
        time();
      },
      1000);
    }
  }
  function jieshu(){
    $.post('/index.php?m=&c=Index&a=kai&id=<?php echo ($kailist["id"]); ?>',{},function(data){
     if(data){
       
      if(data.isid<=3){
        var name = '小';
      }else{
        var name = '大';
      }
      $(".layui-layer-content").html('第'+data.id+'期:'+data.isid+'点,'+name);
      $("#second_show").html(data.isid+'点,'+name);
      $(".layui-layer").show();
      $(".dice").removeClass('dice_<?php echo ($lilist["isid"]); ?>'); 
      $(".dice").addClass('dice_'+data.isid); 
     }else{
        setTimeout(function() {
        jieshu;
      },
      1000);
     } 
     
    },"json");
  }
  function hideshow(){
	$("#buy").hide();
  }
</script>
</body></html>