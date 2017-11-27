<?php

namespace Home\Controller;

use Think\Controller;

class NotifyController extends Controller {

	

	public function _initialize(){

		// 加载配置

		$config = M('config') -> select();

		if(!is_array($config)){

			die('请先在后台设置好各参数');

		}

		foreach($config as $v){

			$key = '_'.$v['name'];

			$this -> $key = unserialize($v['value']);

			$_CFG[$v['name']] = $this -> $key;

		}

		$GLOBALS['_CFG'] = $_CFG;

	}

    

	// 微信支付通知异步页面

	public function index(){



		$jsapi = new \Common\Util\wxjspay;

		$jsapi -> set_param('key', $this -> _mp['key']);

		

		// 验证签名之前必须调用get_notify_data方法获取数据

		$data = $jsapi -> get_notify_data();

		

		file_put_contents('wxpay.log',json_encode($data)."\r\n",FILE_APPEND);

		if(!$jsapi->check_sign()){

			file_put_contents('wxpay.log',"\r\nCHECK SIGN FAIL\r\n",FILE_APPEND);

			// 签名验证失败

			die('FAIL');

		}

		if($data['return_code'] != 'SUCCESS' || $data['result_code'] != 'SUCCESS'){

			file_put_contents('wxpay.log',"\r\RETURN CODE FAIL\r\n",FILE_APPEND);

			die('FAIL');

		}

		$sn = $data['out_trade_no'];

		$money = $data['total_fee']/100;

		$payway = 'wxpay';		

		$type = substr($sn,0,1);
		$buyid =  substr($sn,strlen($sn)-1,1);
		$buyid = $buyid?$buyid:1; 
		$data['log_time'] = NOW_TIME;
        $is_pay = M('wxpay_log')->where(array('out_trade_no'=>$data['out_trade_no']))->find();
		if($is_pay){

			die;

		}		
        // 记录支付日志

		$data['log_time'] = NOW_TIME;

		$data['type'] = $type;

		if($data){

		 M('wxpay_log') -> add($data);

		} 
		$user_info = M('user') ->where(array('openid'=>$data['openid']))->find();
		if($data['out_trade_no']&&$type==6){
          $add['uid'] = $user_info['id'];
          $add['money'] = $money;
          $add['buyid'] = $buyid;
          if($buyid == 1){
    		$name = '香蕉';
	    	}
	      if($buyid == 2){
	    	$name = '西瓜';
	    	}
	      if($buyid == 3){
	    	$name = '苹果';
	    	}
	      $add['buyname'] = $name;
	      $kailist = M('kailog')->where(array('status'=>1))->order('id desc')->find();
          $time = time();
          if(empty($kailist)){
        	$data['starttime'] = $time;
        	$data['endtime'] = $time + 60;
        	$data['status'] = 1;
        	M('kailog')->add($data);
        	$kailist = M('kailog')->where(array('status'=>1))->order('id desc')->find();
          }
          $add['kid'] = $kailist['id'];
          $add['starttime'] = time();
          $add['status'] = 1;
          $add['endtime'] = $kailist['endtime'];
          $info = M('buylog')->add($add);
          if($info){
          	if($buyid == 1){
    		 M('kailog')->where(array('id'=>$kailist['id']))->save(array('kid1'=>$kailist['kid1']+$money,'allmoney'=>$kailist['allmoney']+$money,'allnum'=>$kailist['allnum']+1));
	    	}
	      if($buyid == 2){
	    	M('kailog')->where(array('id'=>$kailist['id']))->save(array('kid2'=>$kailist['kid2']+$money,'allmoney'=>$kailist['allmoney']+$money,'allnum'=>$kailist['allnum']+1));
	    	}
	      if($buyid == 3){
	    	M('kailog')->where(array('id'=>$kailist['id']))->save(array('kid3'=>$kailist['kid3']+$money,'allmoney'=>$kailist['allmoney']+$money,'allnum'=>$kailist['allnum']+1));
	    	}
          }
          expense($user_info,$money,$type);
		}
		// 支付日志

		if(M('wxpay_log') -> where(array('transaction_id' => $data['transaction_id'])) -> find()){

			die('SUCCESS');

		}

		die('SUCCESS');

		

	}// index

	

	// 支付宝同步/异步通知

	public function alipay(){

		$alipay_config['partner'] 		= $GLOBALS['_CFG']['alipay']['pid'];

		$alipay_config['transport']		= 'http';

		$alipay_config['sign_type']		= strtoupper('MD5');

		$alipay_config['key']			= $GLOBALS['_CFG']['alipay']['key'];



		$alipayNotify = new \Common\Util\Alipay\AlipayNotify($alipay_config);

		

		if(IS_POST){

			$verify_result = $alipayNotify->verifyNotify();

		}else{

			$verify_result = $alipayNotify->verifyReturn();

		}

		

		if($verify_result){//验证成功

			

			//商户订单号

			$out_trade_no = $_REQUEST['out_trade_no'];



			//支付宝交易号

			$trade_no = $_REQUEST['trade_no'];



			//交易状态

			$trade_status = $_REQUEST['trade_status'];



			if($_REQUEST['trade_status'] == 'TRADE_FINISHED' || $_REQUEST['trade_status'] == 'TRADE_SUCCESS') {

				// 先判断是否处理

				$has_done = M('alipay_log') -> where(array(

					'out_trade_no' => $out_trade_no,

					'trade_no' => $trade_no

				)) -> find();

				

				// 没有处理过才处理

				if(!$has_done){					

					$money = $_REQUEST['total_fee'];

					$payway = 'alipay';

					

					$type = substr($out_trade_no,0,1);

					

					$tables = array(

						1 => 'land',

						2 => 'user_plant',

						3 => 'user_fertilizer',

						4 => 'charge',

						8 => 'chou'

					);

					$table = $tables[$type];

					if(empty($table)){

						elog('alipay out_trade_no type error');

						die('FAIL');

					}

					$id = substr($out_trade_no,1);

					$info = M($table) -> find($id);



					M($table) -> save(array(

						'id' => $id,

						'status' => 1,

						'pay_time' => NOW_TIME,

						'payway' => 'wxpay',

						'paid' => $money

					));



					// 如果是扩建，则需要增加用户的土地

					if($type == 1){

						M('user') -> where('id='.$info['user_id']) -> setInc('lands');

					}

					// 如果是充值

					elseif($type == 4){

						M('user') -> where('id='.$info['user_id']) -> save(array(

							'money' => array('exp','money+'.$info['money'])

						));

					}

					

					

					M('alipay_log') -> add(array(

						'out_trade_no' => $out_trade_no,

						'trade_no' => $trade_no,

						'total_fee' => $_REQUEST['total_fee'],

						'create_time' => NOW_TIME,

						'seller_email' => $REQUEST['seller_email'],

						'buyer_email' => $REQUEST['buyer_email'],

						'seller_id' => $REQUEST['seller_id'],

						'buyer_id' => $REQUEST['buyer_id'],

					));

				}

			}else die('error');

			

			if(IS_POST){

				echo "success";		//请不要修改或删除

			}

			else{

				redirect('index.php?a=ucenter');

			}

			

		}

		else {

			//验证失败

			echo "fail";

		}

	}
	
	
	public function f2fpay(){
		$info=$_REQUEST;
		//file_put_contents('pay.txt',serialize($info));
		//file_put_contents('payresult.txt',serialize($info).PHP_EOL,FILE_APPEND);
		$ddh = $info['ddh']; //支付宝订单号
		$key = $info['key']; //KEY验证
		$name = $info['name']; //备注信息  接收网关data 参数  支付订单号
		$lb = $info['lb']; //分类 =1 支付宝 =2财付通 =3 微信
		$money = $info['money'];//金额
		$paytime = $info['paytime'];//充值时间
		$key2 = $GLOBALS['_CFG']['site']['f2fkey'];//APPKEY 和云端和软件上面保持一致 
		if($key==$key2){//验证KEY是否正确
			//$result=Db::name('payorder')->where('ordernum',$name)->find();
			$result = M('charge') -> where('orderid',$name)->find();
			//file_put_contents('pay2.txt',serialize($result));
			//KEY正确执行
			if(!empty($result)){
				if($result['status']==1){
					$this->success('此订单已经冲值过了','http://www.baidu.com','','1');
				}else{
					$id=M('charge')->where('orderid',$name)->save(array('money'=>$money,'status' => 1, 'pay_time' => NOW_TIME,'paid' => $money));
					if($id){
						M('user') -> where('id='.$result['user_id']) -> save(array(
							'money' => array('exp','money+'.$info['money'])
						));
						echo "ok";
					}
				}
			}else{
			   //密匙错误
			   echo 'key error'; 
			}
			  //判断支付来源
			  //if($lb==1) $leibie='支付宝';//可根据网站自定义数据
			  //if($lb==2) $leibie='财付通QQ钱包';//可根据网站自定义数据
			  //if($lb==3) $leibie='微信支付';//可根据网站自定义数据
			   /*
			  此处执行你的程序逻辑 回执成功后
			  1、可以做成 判断支付宝订单号是否存在来完成充值
			  2、还可以做成 判断网站订单号(name)来完成充值
			  3、请做好订单号充值判断
			  */
			  //执行完毕回执输出ok 字符
			  //echo "ok";
			
		}else{
			$this->success('操作错误','http://www.baidu.com','','1');
		}
	}

	

	// 抽抽乐

	private function _chou(){

		

	}

}?>