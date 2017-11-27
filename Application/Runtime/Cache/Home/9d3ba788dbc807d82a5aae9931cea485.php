<?php if (!defined('THINK_PATH')) exit();?><html lang="en">

	    <meta content="yes" name="apple-mobile-web-app-capable">
	    <meta content="black" name="apple-mobile-web-app-status-bar-style">
	    <meta content="telephone=no" name="format-detection">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
		<title></title>
		
		<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
		<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

		<link rel="stylesheet" href="/Public/css/reset.css" />
		<!--script type="text/javascript" src="/Public/plugins/layer_mobile/layer.js" >
		</script-->
		<script type="text/javascript" src="/Public/plugins/layer/layer.js" ></script>
		<style>
		.head{ padding:10px; height:50px; position:relative; padding-left:70px; background:#fff; position:relative;}
		.head img.headimg{ width:50px; height:50px; border-radius:50%; position:absolute; top:10px; left:10px;}
		.head .nickname{ font-size:16px;}
		.head .time{ color:#666; font-size:12px;}
		.head .id{ position:absolute; top:10px; right:10px;}
		
		.page a{ background:#f1f1f1; padding:3px 5px; margin-right:5px;}
		
		/*底部*/
		.footer-blank{ height:50px;}
		.footer{ z-index:999; height:50px; background:#ff8a00; color:#fff; position:fixed; width:100%; bottom:0; left:0;}
		.footer a{ color:inherit;}
		.footer ul{
			list-style:none; padding:0; margin:0; text-align:center;
			display:-moz-box; /* Firefox */
			display:-webkit-box; /* Safari and Chrome */
			display:box;
		}
		.footer ul li{
			font-size:14px;
			font-family: "微软雅黑";
			line-height:50px;
			-moz-box-flex:1.0; /* Firefox */
			-webkit-box-flex:1.0; /* Safari 和 Chrome */
			box-flex:1.0;
		}
		.footer ul li span{font-size:16px; padding-top:5px; color: #fff; margin-right:10px;}
		</style> 

		.addr-content{margin-top: 10px; background: #fff;}
		.addr-item{padding-left: 20px; border-bottom: 1px solid #FFD8D8; height: 40px; line-height: 40px; font-family: "微软雅黑"; font-size: 14px; color: #000;}
		.addr-form{padding: 20px 20px 0 20px;}
		.addr-input{margin: 10px 0; }
		.addr-input input{width: 80%; height: 35px;}
		.addr-input .name{}
		.addr-btn{padding: 20px 0;}
		.addr-btn a{display: block; height: 40px; line-height: 40px; background: #FF9900; text-align: center; color: #fff; font-size: 16px; font-family: "微软雅黑";}
		.back2ucenter{ float:right; padding-right:10px;}
		.ubg{ background:url(/Public/images/uc.png) no-repeat; background-size:100%;}
		.head .id{ position:absolute; top:10px; right:0; padding:5px 10px; background:rgba(0,0,0,.5); color:#fff; border-radius:5px 0 0 5px;}
		</style>
		<div class="head ubg">
			<div class="nickname"><?php echo ($user["nickname"]); ?></div>
			<div class="time">推荐人:<?php echo ((isset($parent_info["nickname"]) && ($parent_info["nickname"] !== ""))?($parent_info["nickname"]):'无'); ?>注册时间:<?php echo (date("Y-m-d",$user["sub_time"])); ?></div>
			<img src="<?php echo (headsize($user["headimg"],96)); ?>" class="headimg" />
			<span class="id">ID:<?php echo ($user["id"]); ?></span>
		</div> -->
        <!-- <a href="/Ssc/index.html" class="weui-tabbar__item">
            <i class="my-bet-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">时时彩</p>
        </a> -->
         <a href="/" class="weui-tabbar__item">
            <i class="dice-icon-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">猜大小</p>
        </a>
        <a href="/index.php?m=&c=Index&a=usercode" class="weui-tabbar__item">
            <i class="myShare-icon-1 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">分享赚钱</p>
        </a>
        <a href="/index.php?m=&c=Index&a=ucenter" class="weui-tabbar__item">
            <i class="personCenter-icon-2 weui-tabbar__icon "></i>
            <p class="weui-tabbar__label">个人中心</p>
        </a>
    </div>


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


