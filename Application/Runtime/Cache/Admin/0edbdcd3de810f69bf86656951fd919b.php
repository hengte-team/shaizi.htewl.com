<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><title>管理后台</title><link rel="stylesheet" href="/Public/admin/css/style.default.css" type="text/css" /><link rel="stylesheet" href="/Public/plugins/bootstrap/css/bootstrap.font.css" type="text/css" /><script type="text/javascript" src="/Public/admin/js/plugins/jquery-1.7.min.js"></script><script type="text/javascript" src="/Public/admin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script><script type="text/javascript" src="/Public/admin/js/plugins/jquery.cookie.js"></script><script type="text/javascript" src="/Public/admin/js/custom/general.js"></script><!--[if IE 9]>    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/><![endif]--><!--[if IE 8]>    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/><![endif]--><!--[if lt IE 9]>	<script src="js/plugins/css3-mediaqueries.js"></script><![endif]--><meta name="poweredby" content="htewl.com" />

<li>				<a href="<?php echo U('Product/kai');?>" class="editor">					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>					<span class="text">开奖列表</span>				</a>            </li>
<li>				<a href="<?php echo U('Product/buy');?>" class="editor">					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>					<span class="text">购买列表</span>				</a>            </li>
<!-- 			<li>				<a href="<?php echo U('Chou/index');?>" class="editor">					<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>					<span class="text">抽抽乐</span>				</a>            </li> -->			<li>				<a href="<?php echo U('Finance/withdraw');?>" class="editor">					<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>					<span class="text">提现记录</span>				</a>            </li>			<!-- <li>				<a href="<?php echo U('Finance/pickup');?>" class="editor">					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>					<span class="text">采摘记录</span>				</a>            </li> -->		<!-- 	<li>				<a href="<?php echo U('Finance/tou');?>" class="editor">					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>					<span class="text">偷菜记录</span>				</a>            </li> -->			<li>				<a href="<?php echo U('Finance/expense');?>" class="editor">					<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>					<span class="text">佣金记录</span>				</a>            </li>						<li>				<a href="<?php echo U('Autoreply/index');?>" class="editor">					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>					<span class="text">关键词回复设置</span>				</a>            </li>			<li>				<a href="<?php echo U('Selfmenu/index');?>" class="widgets">					<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>					<span class="text">自定义菜单管理</span>				</a>            </li>			<li>				<a href="#sms">					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>					<span class="text">短信管理</span>				</a>            	<span class="arrow"></span>            	<ul id="sms">               		<li><a href="<?php echo U('Sms/send');?>">发送短信</a></li>					<li><a href="<?php echo U('Sms/log');?>">短信记录</a></li>					<li><a href="<?php echo U('Sms/dashbord');?>">短信概况</a></li>                </ul>            </li>			        </ul>        <a class="togglemenu"></a>        <br /><br />    </div><!--leftmenu-->            <div class="centercontent">		
        <div class="pageheader notab">
            <h1 class="pagetitle">充值</h1>
        </div><!--pageheader-->
        <script src="/Public/plugins/My97DatePicker/WdatePicker.js"></script>
        <div id="contentwrapper" class="contentwrapper lineheight21">
        
        
            <form class="stdform stdform2" method="post">
				<table class="form-table" cellspacing="1" border="0">
					<tr>
						<th class="title">用户ID</th>
						<td>
							<input type="text" name="user_id" id="user_id" value="<?php echo ($_GET["id"]); ?>" class="smallinput" />
						</td>
					</tr>
					
					<tr>
						<th class="title">金额</th>
						<td>
							<input type="text" name="money" id="money" value="<?php echo ($_GET["money"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">备注</th>
						<td>
							<input type="text" name="remark" id="remark" value="<?php echo ($_GET["remark"]); ?>" class="smallinput" />
						</td>
					</tr>
					
				</table>
				
				
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
        
        </div><!--contentwrapper-->
        	</div><!-- centercontent -->        </div><!--bodywrapper--><script>	jQuery(document).ready(function(e){						// 菜单添加提示 		$ = jQuery;				// 根据cookie打开对应的菜单		if($.cookie('curIndex')){			console.log($.cookie('curIndex'));			$(".vernav2>ul>li").eq($.cookie('curIndex')).find('ul').show();		}				$(".vernav2 ul li").each(function(index, el){			$(this).attr('title', $(this).find("a").find('span.text').text());					});						$(".vernav2>ul>li>a").each(function(index,el){			$(el).on('click',function(e){				$.cookie('curIndex',$(this).parent('li').index());			});		});						// 调整默认选择内容		$("select").each(function(index, element) {			$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');		});		// 调整提示内容	});</script></body></html>