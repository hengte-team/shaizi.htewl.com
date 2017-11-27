<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends HomeController {
	public function _initialize(){
		parent::_initialize();
	}
	
    public function index(){
		// 验证URL
		if(isset($_GET['echostr'])){
			die($_GET['echostr']);
		}
		
		$dd = new \Common\Util\ddwechat;
		$this -> dd = $dd;
		$this -> data = $dd -> request();

		// 判断mp配置
		if(!$this -> _mp){
			$dd -> response('管理员没有配置公众号信息');
			exit;
		}
		
		// TODO 可以在这里判断fromusername和配置中的微信数据是否匹配来增加安全性
		if($this -> _mp['gh_id'] != $this -> data['tousername']){
			$dd -> response('来源非法,请联系管理员!');
		}
		
		$dd -> setParam($this -> _mp);
		
		// 查询用户信息
		$this -> user = M('user') -> where(array(
			'openid' => $this -> data['fromusername']
		)) -> find();
		
		// 没有用户信息则创建
		if(!$this -> user){
			$accesstoken = $dd -> getaccesstoken();
			if(!$accesstoken && APP_DEBUG){
				$dd -> response('accesstoken获取失败:' . $dd -> errmsg);
			}
			$wechat_user = $dd -> getuserinfo($this -> data['fromusername']);
			if(!$wechat_user){
				$dd -> response('获取用户信息失败:'. $dd -> errmsg);
			}
			$wechat_user['id'] = M('user') -> add($wechat_user);
			if(!$wechat_user['id']){
				$dd -> response('创建用户失败');
				exit;
			}
			$this -> user = $wechat_user;
		}
		
		$method = 'reply_'.strtolower($this -> data['msgtype']);
		$this -> call_function($method);
    }
	
	// 处理文本回复
	private function reply_text(){
		$this -> reply_by_keyword($this -> data['content']);
	}
	
	// 处理图片回复
	private function reply_image(){
		M('recieve_image') -> add(array(
			'user_id' => $this -> user['id'],
			'url' => $this -> data['picurl'],
			'media_id' => $this -> data['mediaid'],
			'create_time' => NOW_TIME
		));
	}
	
	// 处理事件回复
	private function reply_event(){
		$method = 'reply_event_'.strtolower($this -> data['event']);
		$this -> call_function($method);
	}
	
	// 处理事件回复  - 关注事件
	private function reply_event_subscribe(){
		//如果设置了关注时回复关键词则调用回复
		if(!empty($this -> _site['subscribe'])){
			$this -> reply_by_keyword($this -> _site['subscribe']);
		}
		
		// 忽略断开
		ignore_user_abort();
		$user_info = M('user') -> where("openid='".$this -> data['fromusername']."'") -> find();
		if(!$user_info){
			// 首次关注,将用户信息保存到数据库
			$accesstoken = $this -> dd -> getaccesstoken();
			$user = $this -> dd -> getuserinfo($this -> data['fromusername']);
			if(!$user){
				elog($this -> dd -> errmsg);
				$this -> dd -> response('获取用户信息失败:'. $this -> dd -> errmsg);
				exit;
			}
			$user['last_interact'] = NOW_TIME;
			M('user') -> add($user);
		}
	}
	
	// 处理事件回复  - 取消关注事件
	private function reply_event_unsubscribe(){
		M('user') -> where(array(
			'openid' => $this -> data['fromusername']
		)) -> setField('subscribe',0);
	}
	
	// 处理事件回复  - 点击自定义菜单
	private function reply_event_click(){
		// 进入群聊
		if($this -> data['eventkey'] == '#enter'){
			M('user') -> where(array('openid' => $this -> data['fromusername'])) -> setField('is_chating',1);
			
			// 查询当前有多少人群聊
			$count = M('user') -> where(array(
				'is_chating' => 1,
				'last_interact' => array('gt',NOW_TIME-48*3600)
			)) -> count();
			$msg = "欢迎加入群聊\r\n当前群聊一共有{$count}人\r\n---------\r\n在下面发送消息即可发言,目前只支持文字";
			$msg = "群聊测试已结束，感谢您的参与！";
			$this -> dd -> response($msg);
		}
		elseif($this -> data['eventkey'] == '#quit'){
			M('user') -> where(array('openid' => $this -> data['fromusername'])) -> setField('is_chating',0);
			$this -> dd -> response('您已退出群聊，不会再收到其他人发送的消息！感谢您的使用！');
		}
		if(!empty($this -> data['eventkey'])){
			$this -> reply_by_keyword($this -> data['eventkey']);
		}
	}
	
	// 判断某个方法是否存在，存在则调用
	private function call_function($method){
		if(method_exists($this,$method)){
			return $this -> $method();
		}
		return false;
	}
	
	
	// 根据关键词回复
	private function reply_by_keyword($key){
		$dd = &$this -> dd;
		$reply = M('autoreply') -> where(array(
			'status' => 1,
			'_string' => "find_in_set('{$key}',keyword)"
		)) -> fetchSql(0) -> find();
		
		// 没有关键词对应回复
		if(empty($reply)){
			// exit('success');
		}
		
		// 只有用一条记录,且是文本回复
		elseif($reply['type'] == 1){
			$dd -> response($reply['content']);
		}
		
		// 多条记录或者一条图文记录都是图文回复
		elseif(!empty($reply['content'])){
			// 查询所有文章
			$articles = M('article') -> where(array(
				'id' => array('in', $reply['content'])
			)) -> limit(10) -> order('id desc') -> select();
			
			//$dd -> response(M() -> getLastSql());exit;
			
			foreach($articles as $article){
				$msgs[] = array(
					'title' => $article['title'],
					'description' => $article['desc'],
					'picurl' => !empty($article['cover']) ? complete_url($article['cover']) : '',
					'url' => complete_url(U('Index/article?id='.$article['id']))
				);
			}
			$dd -> response(array('articles' => $msgs), 'news');
		}
	}
}?>