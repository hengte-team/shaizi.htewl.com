<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><title>管理后台</title><link rel="stylesheet" href="/Public/admin/css/style.default.css" type="text/css" /><link rel="stylesheet" href="/Public/plugins/bootstrap/css/bootstrap.font.css" type="text/css" /><script type="text/javascript" src="/Public/admin/js/plugins/jquery-1.7.min.js"></script><script type="text/javascript" src="/Public/admin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script><script type="text/javascript" src="/Public/admin/js/plugins/jquery.cookie.js"></script><script type="text/javascript" src="/Public/admin/js/custom/general.js"></script><!--[if IE 9]>    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/><![endif]--><!--[if IE 8]>    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/><![endif]--><!--[if lt IE 9]>	<script src="js/plugins/css3-mediaqueries.js"></script><![endif]--><meta name="poweredby" content="htewl.com" />

<li>				<a href="<?php echo U('Product/kai');?>" class="editor">					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>					<span class="text">开奖列表</span>				</a>            </li>
<li>				<a href="<?php echo U('Product/buy');?>" class="editor">					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>					<span class="text">购买列表</span>				</a>            </li>
<!-- 			<li>				<a href="<?php echo U('Chou/index');?>" class="editor">					<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>					<span class="text">抽抽乐</span>				</a>            </li> -->			<li>				<a href="<?php echo U('Finance/withdraw');?>" class="editor">					<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>					<span class="text">提现记录</span>				</a>            </li>			<!-- <li>				<a href="<?php echo U('Finance/pickup');?>" class="editor">					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>					<span class="text">采摘记录</span>				</a>            </li> -->		<!-- 	<li>				<a href="<?php echo U('Finance/tou');?>" class="editor">					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>					<span class="text">偷菜记录</span>				</a>            </li> -->			<li>				<a href="<?php echo U('Finance/expense');?>" class="editor">					<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>					<span class="text">佣金记录</span>				</a>            </li>						<li>				<a href="<?php echo U('Autoreply/index');?>" class="editor">					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>					<span class="text">关键词回复设置</span>				</a>            </li>			<li>				<a href="<?php echo U('Selfmenu/index');?>" class="widgets">					<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>					<span class="text">自定义菜单管理</span>				</a>            </li>			<li>				<a href="#sms">					<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>					<span class="text">短信管理</span>				</a>            	<span class="arrow"></span>            	<ul id="sms">               		<li><a href="<?php echo U('Sms/send');?>">发送短信</a></li>					<li><a href="<?php echo U('Sms/log');?>">短信记录</a></li>					<li><a href="<?php echo U('Sms/dashbord');?>">短信概况</a></li>                </ul>            </li>			        </ul>        <a class="togglemenu"></a>        <br /><br />    </div><!--leftmenu-->            <div class="centercontent">		<style type="text/css">
	a{
		cursor: pointer;
	}
</style>
<div class="pageheader notab">


            <h1 class="pagetitle">开奖记录</h1>


            <span class="pagedesc"></span>

        </div><!--pageheader-->

        <div id="contentwrapper" class="contentwrapper lineheight21">

			<table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">


				<thead>


					<tr>
						<th class="head1">ID</th>
						<th class="head0">开始时间</th>
						<th class="head0">结束时间</th>
						<th class="head0">总金额</th>
						<th class="head0">下单量</th>
						<th class="head0">状态</th>
						<th class="head0">1金额</th>
						<th class="head0">2金额</th>
						<th class="head0">3金额</th>
						<th class="head0">4金额</th>
						<th class="head0">5金额</th>
						<th class="head0">6金额</th>
						<th class="head0">大金额</th>
						<th class="head0">小金额</th>
						<th class="head0">开奖结果</th>
						<th class="head0">控制结果</th>

					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vo["starttime"])); ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vo["endtime"])); ?></td>
						<td><?php echo ($vo["allmoney"]); ?></td>
						<td><?php echo ($vo["allnum"]); ?></td>
						<td><?php if($vo['status']==1){ echo '<span style="color:#ea2000;">进行中</span>';}if($vo['status']==2){ echo '已结束';}?></td>
                        <td><?php echo ($vo["kid1"]); ?></td>
                        <td><?php echo ($vo["kid2"]); ?></td>
                        <td><?php echo ($vo["kid3"]); ?></td>
                        <td><?php echo ($vo["kid4"]); ?></td>
                        <td><?php echo ($vo["kid5"]); ?></td>
                        <td><?php echo ($vo["kid6"]); ?></td>
                        <td><?php echo ($vo["da"]); ?></td>
                        <td><?php echo ($vo["xiao"]); ?></td>
                        <td><?php echo ($vo["isid"]); ?></td>
                        <td><a onclick="kong(<?php echo ($vo["id"]); ?>,1)">1</a> &nbsp;<a onclick="kong(<?php echo ($vo["id"]); ?>,2)">2</a> &nbsp;<a onclick="kong(<?php echo ($vo["id"]); ?>,3)">3</a> &nbsp;<a onclick="kong(<?php echo ($vo["id"]); ?>,4)">4</a> &nbsp;<a onclick="kong(<?php echo ($vo["id"]); ?>,5)">5</a> &nbsp;<a onclick="kong(<?php echo ($vo["id"]); ?>,6)">6</a> &nbsp;</td>

					</tr><?php endforeach; endif; else: echo "" ;endif; ?>


				</tbody>


			</table>


			<div class="dataTables_paginate paging_full_numbers" id="dyntable2_paginate">


			<?php echo ((isset($page) && ($page !== ""))?($page):"<p style='text-align:center'>暂时没有数据</p>"); ?>


			</div>


        


        </div><!--contentwrapper-->


        <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>


       <script type="text/javascript">
       	 function kong(kid,id){
            $.post("/yuan.php?m=Admin&c=Product&a=kong",{kid:kid,id:id},function(d){
              if(d.status==1){
              	alert('第'+kid+'期控制开奖结果是'+d.id);
              }else{
              	alert(d.info);
              }
            },'json');
       	 }
       </script>	</div><!-- centercontent -->        </div><!--bodywrapper--><script>	jQuery(document).ready(function(e){						// 菜单添加提示 		$ = jQuery;				// 根据cookie打开对应的菜单		if($.cookie('curIndex')){			console.log($.cookie('curIndex'));			$(".vernav2>ul>li").eq($.cookie('curIndex')).find('ul').show();		}				$(".vernav2 ul li").each(function(index, el){			$(this).attr('title', $(this).find("a").find('span.text').text());					});						$(".vernav2>ul>li>a").each(function(index,el){			$(el).on('click',function(e){				$.cookie('curIndex',$(this).parent('li').index());			});		});						// 调整默认选择内容		$("select").each(function(index, element) {			$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');		});		// 调整提示内容	});</script></body></html>