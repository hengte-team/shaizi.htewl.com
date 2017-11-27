<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends AdminController {
    // 列表
	public function index(){
		$_GET = array_merge($_GET,$_POST);
		$where = array();
		if(!empty($_GET['id'])){
			$where['id'] = intval($_GET['id']);
		}
		if(!empty($_GET['mobile'])){
			$where['mobile'] = $_GET['mobile'];
		}
		if(!empty($_GET['name'])){
			$where['name'] = $_GET['name'];
		}
		if(IS_POST){
			if($_POST['id']){
				$id = '';
				foreach($_POST['id'] as $vo){
					$ids = $vo.','.$ids;
				}
				$ids = substr($ids,0,strlen($ids)-1);
				if($_POST['tongdao']){
				  if($_POST['tongdao']=='成为通道会员'){
                    $up['is_tong'] = 1;
				  }else{
                    $up['is_tong'] = 0;
				  }
				  M('user')->where(array('id'=>array('in',$ids)))->save($up);
	
				}
				if($_POST['gongpai']){
                  if($_POST['gongpai']=='增加一个公排会员'){
                    foreach($_POST['id'] as $vo){
                    	$userinfo  = M('user')->where(array('id'=>$vo))->find();
                    	//执行公排
                    	//$is_gong = is_gongpai($userinfo['id']); //检查是否已经公排
                    	//if( !$is_gong ){
                           paiwei($userinfo);
                    	//}
                    }
				  }
				  if($_POST['gongpai']=='删除一个公排会员'){
                    //删除公排信息
                    foreach($_POST['id'] as $vo){
                    	$gong  = M('tree')->where(array('user_id'=>$vo))->order('id desc')->find();
                    	M('tree')->where(array('id'=>$gong['id']))->delete();
                    	$gong  = M('tree')->where(array('user_id'=>$vo))->order('id desc')->find();
                    	//如果用户已经没有公排位置
                    	if(! $gong){

                    	 M('land')->where(array('user_id'=>$vo))->delete();

                    	}
                    }
				  }
				}
				$this->success('操作成功','/bst_admin.php?m=Admin&c=User&a=index');
			}
		}
		$this -> _list('user',$where);
	}
	
	// 编辑、添加
	public function edit(){
		$id = intval($_GET['id']);
		$info = M('user') -> find($id);
		if(!$info){
			$this -> error('操作错误');
		}
		if(IS_POST){
			// 无上级才能修改上级
			if(!$info['parent1'] && !empty($_POST['parent1']) && $_POST['parent1'] != $info['parent1']){
				$parent_info = M('user') -> find(intval($_POST['parent1']));
				if(!$parent_info){
					$this -> error('推荐人无效');
				}
				$_POST['parent1'] = $parent_info['id'];
				for($i=1;$i<=9;$i++){
					$ii = $i+1;
					$_POST['parent'.$ii] = $parent_info['parent'.$i];
				}
				
				M('user') -> where(array('id' => $parent_info['id'])) -> setInc('agent1');
				M('user') -> where(array('id' => $parent_info['parent1'])) -> setInc('agent2');
				M('user') -> where(array('id' => $parent_info['parent2'])) -> setInc('agent3');
			}
		}
		$this -> _edit('user');
	}
	
	// 删除商品
	public function del(){
		$this -> _del('user', $_GET['id']);
		$this -> success('删除成功！');
	}
	
	// 充值
	public function charge(){
		if(IS_POST){
			$user_id = intval($_POST['user_id']);
			$find = M('user') -> find($user_id);
			if(!$find){
				$this -> error('用户不存在');
			}
			$money = floatval($_POST['money']);
			M('charge_log') -> add(array(
				'user_id' => $user_id,
				'money' => $money,
				'remark' => $_POST['remak'],
				'create_time' => NOW_TIME
			));
			M('user') -> save(array(
				'id' => $user_id,
				'money' => array('exp','money+'.$money)
			));
			flog($user_id,'money',$money,7);
			$this -> success('操作成功');
			exit;
		}
		$this -> display();
	}
}