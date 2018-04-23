<?php
require_once dirname(__FILE__).'/../test/momo.class.php';
class indexController extends commonController{
	private $user;
	private $condition = 30000;
	private $userModel;
	private $istest;
	function __construct()
	{
		parent::__construct();
		$this->user = new momoController();
		$this->userModel = new Mobile_UserModel();
		// $this->istest = 'test';s
		//$this->istest = '';
	}

	public function indexAction(){
		$this->assign("public", "public.tpl");
		//	$this->redirect("?c=home");
		//跳转到第一个用户有权限的页面
//		if(isset($_SESSION['admin']['firstPrivilegedMenu']['conf'])){
//			$conf = $_SESSION['admin']['firstPrivilegedMenu']['conf'];
//
//			$url = "/index.php?m={$conf['auth']['m']}";
//			switch($conf['auth']['type']){
//			case "mc":	$url .= "&c=".$conf['auth']['c']; break;
//			case "mca":	$url .= "&c=".$conf['auth']['c']."&a=".$conf['auth']['a']; break;
//			}
//			$this->back_or($url);
//
//		}
		//这个执行不到
		$this->render("index.tpl");
		
	}
	
	//登录
	public function loginAction(){

		$this->render("login.tpl");
	}

	//登录处理
	public function login_inAction(){

	}

	//代理列表
	public function myagentAction(){
		$this->assign("public", "public.tpl");
		$sql = "select a.user_name,a.nick_name,a.id,a.addtime,a.user_coins,b.user_name as buser_name,b.nick_name as bnick_name  from tb_sys_user a LEFT JOIN tb_sys_user b on a.parent_id = b.id  where a.parent_id=".$_SESSION['admin']['id']."";
		$arr = \Doris\DDB::fetchAll($sql);
		//print_r($arr);
		$this->assign("agents",$arr);
		$this->render("myagent.tpl");
	}

	//返利列表
	public function myrebateAction(){
		$where = ' 1=1';
		if($_POST){
			if(!empty($_POST['statime'])){
				$_SESSION['rstatime'] = $_POST['statime'];
				$where .= " and re_time>=".strtotime($_SESSION['rstatime']);
			}
			if(!empty($_POST['endtime'])){
				$_SESSION['rendtime'] = $_POST['endtime'];
				$where .= " and re_time<".strtotime($_SESSION['rendtime']);
			}
		}
		$rebates = \Doris\DDB::fetchAll("select * from tb_user_rebate left join tb_sys_user on tb_user_rebate.to_id=tb_sys_user.id where $where and userid=".$_SESSION['admin']['id']);
		$this->assign("rebates",$rebates);
		$this->assign("public", "public.tpl");
		$this->render("myrebate.tpl");
	}

	//我的信息
	public function myinfoAction(){
		$this->assign("public", "public.tpl");
		$this->render("myinfo.tpl");
	}

	//俱乐部
	public function myclubAction(){
		$clubs = \Doris\DDB::fetchAll('select * from tb_club where user_id='.$_SESSION['admin']['id']);
		$this->assign('clubs',$clubs);
		$this->render("club.tpl");
	}

	//赠送钻石
	public function sendAction(){
		$this->assign("public", "public.tpl");
		$this->render("send.tpl");
	}

	//修改密码
	public function pass_chAction(){
		if($_POST){
			if($_POST['newspassword1'] != $_POST['newspassword2']){
				$this->error('两次密码不一样');
			}
			$count = \Doris\DDB::fetchAll("select * from tb_sys_user  where user_pwd='".md5(md5($_POST['oldpassword']))."' and id=".$_SESSION['admin']['id']);
			if(count($count) < 1){
				$this->error('原密码错误');
			}
			if(!Doris\DDB::execute("update tb_sys_user set user_pwd='".md5(md5($_POST['newspassword1']))."' where id=".$_SESSION['admin']['id'])){
				$this->error('修改失败');
			}
			$this->success('修改成功','/index.php');
		}
		$this->assign("public", "public.tpl");
		$this->render("changepass.tpl");
	}

	//钻石充值
	public function c_rechargeAction(){
		$goods = \Doris\DDB::fetchAll('select * from tb_recharge_type order by amount asc');
		$this->assign("goods",$goods);
		//print_r($goods);
		$this->assign("public", "public.tpl");
		$this->render("c_recharge.tpl");
	}


	//玩家充值
	public function u_rechargeAction(){
		// $sign_arr = [ 'memberid'=>10500 ];
		if (!empty(@$_POST['uid'])) {
			$sign_arr = ['memberid'=>@$_POST['uid'] ];
			setcookie("memberid",@$_POST['uid']);
		} else {
			$sign_arr['memberid'] = empty($_COOKIE['memberid'])?"":$_COOKIE['memberid'];
		}
		// if(!isset($_POST['uid'])){
		// 	$sign_arr = [ 'memberid'=>10500 ];
		// }
		$arr = $this->user->userinfo($sign_arr);
		$arr = $this->user->object2array(json_decode($arr));
		if($arr['code'] != 0){
			$this->assign('msg','没有找到该玩家的相关信息');
		}else{
			$_SESSION['g_user'] = $this->user->object2array(json_decode($arr['dataObject']));
			$this->assign('user',$_SESSION['g_user']);
		}
		$this->assign('memberid',$sign_arr['memberid']);
		$this->assign("public", "public.tpl");
		$this->render("u_recharge.tpl");
	}

	//售钻统计
	public function saleAction(){
		$snum = 0;
		$where = ' 1=1';
		if($_POST){
			if(!empty($_POST['sstatime'])){
				$_SESSION['sstatime'] = $_POST['sstatime'];
				$where .= " and recharge_time>=".strtotime($_SESSION['sstatime']);
			}
			if(!empty($_POST['sendtime'])){
				$_SESSION['sendtime'] = $_POST['sendtime'];
				$where .= " and recharge_time<".strtotime($_SESSION['sendtime']);
			}
		}
		$orders = \Doris\DDB::fetchAll("select * from tb_recharge_cards where $where and userid=".$_SESSION['admin']['id']);
		foreach($orders as $v){
			$snum += $v['counts'];
		}
		$this->assign('snum',$snum);
		$this->assign("orders", $orders);
		$this->assign("public", "public.tpl");
		$this->render("sale.tpl");
	}

	//购钻统计
	public function buyAction(){
		$where = ' and 1=1';
		if($_POST){
			if(!empty($_POST['statime'])){
				$_SESSION['statime'] = $_POST['statime'];
				$where .= " and paytime>=".strtotime($_SESSION['statime']);
			}
			if(!empty($_POST['endtime'])){
				$_SESSION['endtime'] = $_POST['endtime'];
				$where .= " and paytime<".strtotime($_SESSION['endtime']);
			}
		}
		$orders = \Doris\DDB::fetchAll("select * from tb_recharge_order where paystate=1 $where and userid=".$_SESSION['admin']['id']);
		$this->assign("orders", $orders);
		$this->assign("public", "public.tpl");
		$this->render("buy.tpl");
	}


	//申请总代
	/**
	**	当用户单词购买超过10000的房卡或者累计超过30000即可申请
	 **/
	public function to_upAction(){
		$smount = $this->userModel->isup();
		$this->assign('smount',(int)$smount);
		$this->assign('scon',$this->condition);
		if($smount >= $this->condition) {

			$this->assign('con','yes');
		}
		$this->assign("public", "public.tpl");
		$this->render("to_up.tpl");

	}


	public function sapplyAction(){
		$smount = $this->userModel->isup();
		if($smount >= $this->condition) {

			$data = [
				'userid' => $_SESSION['admin']['id'],
				'name' => $_SESSION['admin']['nick_name'],
				'amount' => $smount,
				'differ' => $this->condition-$smount,
				'apptime' => time()
			];
			$res = \Doris\DDB::add('tb_apply',$data);
			if($res){
				$_SESSION['isup'] = 1;
				echo  1;
			}else{
				echo  0;
			}
		}
	}


	//创建俱乐部
	public function club_addAction(){
		if ($_POST) {
			if ($_POST['csrf_token'] != $_SESSION['csrf_token'])
				$this->error("为防止重复提交请刷新界面！");
			else 
				$_SESSION['csrf_token'] = '';
			$data = [
				'clubname' => (string)$_POST['club_name'],
				'memberid' => (int)$_POST['player_id'],
			];
			if ($_SESSION['admin']['user_coins'] < 100 ) {
				$this->error("余额少于100,请充值");
			}
			if($this->istest == 'test'){
				$res = $this->user->test_clubadd($data,$_POST['app']);
			}else{
				$res = $this->user->clubadd($data,$_POST['app']);
			}
			$res2 = $this->user->object2array($res['dataObject']);
			if ($res['code'] == 0) {
				if (!empty($res2) && $res2['code'] == 0) {					
					\Doris\DDB::execute("update tb_sys_user set user_coins=user_coins+188 where id=".$_SESSION['admin']['id']);
					$arr = [
							'c_name' => (string)$_POST['club_name'],
							'game_id' => $_POST['app'],
							'create_time' => time(),
							'user_id' => $_SESSION['admin']['id'],
							'yx_id'	=> (int)$_POST['player_id'],
					];
					if(\Doris\DDB::add('tb_club',$arr)){					
						$this->success("创建成功","index.php?m=index&c=index&a=myclub");
					}
					
				} else {
					if (empty($res2['Description'])) {
						$this->error('错误码：'.$res2['code'].'--参数错误');
					} else {
						if ($res2['Description'] == '用户已经是代理')
							$this->error('跑胡子，跑得快，牛牛只创建一个俱乐部即可');
						else
							$this->error('错误码：'.$res2['code'].'--'.$res2['Description']);
					}
				}
			} else {
				$this->error($res['Description']);
			}
		}
		if ($this->istest == 'test') {
			$games = $this->user->test_gamelist();
		} else {
			$games = $this->user->gamelist();
		}
		foreach(json_decode($games['dataObject']) as $v){
			$game[] = $this->user->object2array($v);
		}
		$have_clud = \Doris\DDB::fetchAll("select game_id as have_clud from tb_club where user_id=".$_SESSION['admin']['id']);
		$club_res = [];
		foreach ($have_clud as $key => $value) {
			$club_res[] =  $value['have_clud'];
		}
		$this->assign('game',$game);
		if($games['code']==0){
			$games = $this->user->object2array($games['dataObject']);
			$this->assign('games',$games);
			$this->assign('have_clud',$club_res);
			$_SESSION['csrf_token'] = rand(00000001,9999999999).time();
		}

		$this->render("club_add.tpl");

	}

	//俱乐部
	public function clubAction(){
		$club = \Doris\DDB::fetch("select * from tb_club where id=".$_GET['club_id']);
		$_SESSION['club'] = $club;
		$this->assign("club",$club);
		$this->render("club_mana.tpl");
	}

	//检测用户是否存在
	public function check_userAction(){
		$data = [
			"memberid" => (int)$_GET['gid']
		];
		if($this->istest == 'test'){
			$res = $this->user->test_userext($data);
		}else{
			$res = $this->user->userext($data);
		}
		if ($res['code'] != 0 ) {
			echo 2;
		}
		if($res['dataObject'] == 1){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function rechargAction()
	{
		$num = (int)$_POST['num'];
		$user_id = $_POST['user_id'];
		// 判断用户ID是否存在
		$user = \Doris\DDB::fetch("select * from tb_sys_user where id=".$user_id);
		if (!empty($user)) {
			if ((int)$_SESSION['admin']['user_coins'] > $num) {
				//用户被减
				\Doris\DDB::execute('update tb_sys_user set user_coins=user_coins-'.$num.' where id='.$_SESSION['admin']['id'].'');
				$data1 = [
					'oper_id' => $_SESSION['admin']['id'],
					'user_id' => $user_id,
					'user_coins' => -$num,
					'create_time' => time(),
					'flag' => 3
				];
				\Doris\DDB::add('tb_recharge_flow',$data1);   //写流水
				//用户被加
				\Doris\DDB::execute('update tb_sys_user set user_coins=user_coins+'.$num.' where id='.$user_id.'');

				$data2 = [
					'oper_id' => $_SESSION['admin']['id'],
					'user_id' => $user_id,
					'user_coins' => $num,
					'create_time' => time(),
					'flag' => 2
				];
				\Doris\DDB::add('tb_recharge_flow',$data2);   //写流水
				echo json_encode(['code'=>'0','info'=>'充值成功','data'=>$num]);
			} else {
				echo json_encode(['code'=>'2','info'=>'余额不足无法给代理充值']);
			}
		} else {
			echo json_encode(['code'=>'2','info'=>'系统异常']);
		}
		
	}

	//同意协议
	public function agreementAction(){
		$this->render("agreement.tpl");
	}

	public function sysmsgAction(){
		echo "该功能暂未开通";
	}

	//添加代理
	public function addagentAction(){
		if($_POST){
			$data = [
				'nick_name' => $_POST['nick_name'],
				'wexin' => $_POST['wexin'],
				'phone' => $_POST['phone'],
				'user_name' => $_POST['phone'],
				'user_pwd' => md5(md5('123456')),
				'parent_id' => $_SESSION['admin']['id'],
				'id_no' => $_POST['id_no'],
				'user_level' => 6,
				'addtime' => time(),
				'ser_addr' => $_POST['service_city'],
				'addr' => $_POST['province'].$_POST['city'].$_POST['area'].$_POST['address']
			];

			$res = \Doris\DDB::add('tb_sys_user',$data);
			if($res){
				$this->success('添加成功');
			}else{
				$this->success('添加失败，请稍后重试');
			}
		}else{
			$this->assign("public", "public.tpl");
			$this->render("agent_add.tpl");
		}
	}

	//验证数据库字段唯一
	public function checkoneAction(){
		$field = $_GET['field'];
		$value = $_GET['value'];
		$res = \Doris\DDB::fetch("select * from tb_sys_user where $field='$value'");
		if($res){
			echo 1;
		}
		echo 0;
	}

	//去给用户充值页面
	public function torechargeAction(){
		if($_POST){
			if ($_POST['num'] < 1) {
				$this->error('充值金额需要大于0');
			}
			$data = [
				'userid' => $_SESSION['admin']['id'],
				'counts' => $_POST['num'],
				'recharge_id' => $_POST['play_id'],
				'recharge_time' => time()
			];
			$res = \Doris\DDB::add('tb_recharge_cards',$data);
			if(!$res){
				$this->error('充值失败,请稍后再试');
			}
			$rarr = [
				'orderid' => "cz".time().rand(1000,9999).$_SESSION['admin']['id'],
				'memberid' => (int)$_POST['play_id'],
				'beans' => (int)$_POST['num']
			];
			if($_SESSION['admin']['user_coins']>=$_POST['num'] && $_SESSION['admin']['user_coins']>0){
				//余额操作
				\Doris\DDB::execute("update tb_sys_user set user_coins=user_coins-".$_POST['num']." where id=".$_SESSION['admin']['id']);
				$_SESSION['admin']['user_coins'] -= $_POST['num'];

				if($this->istest == 'test'){
					$user_res = $this->user->test_recharge($rarr);
				}else{
					$user_res = $this->user->recharge($rarr);
				}
				if($user_res['code'] == 0){
					$this->success('充值成功');
				}
			}else{
				\Doris\DDB::execute("delete from tb_recharge_cards where id=".$res['last_id']);
				$this->error('余额不足请充值');
			}
		}else{
			$this->assign("g_user", $_SESSION['g_user']);
			$this->assign("public", "public.tpl");
			$this->render("to_recharge.tpl");
		}
	}

	//修改个人信息
	public function up_myinfoAction(){
		if($_POST){
			$res = \Doris\DDB::execute("update tb_sys_user set nick_name='".$_POST["nick_name"]."' where id=".$_SESSION['admin']['id']);
			if(!$res){
				$this->error('修改失败，请重新提交');
			}
			$this->success('修改成功','/index.php');
			$_SESSION['admin']['nick_name'] = $_POST["nick_name"];
		}
		$this->assign("public", "public.tpl");
		$this->render("upmyinfo.tpl");
	}


	//战绩查询
	public function play_logAction(){
		if($_POST){
			$data = [
				'memberid' => $_POST['select_val'],
				'begin' => $_POST['endtime'],
				'end' => date('Y-m-d',strtotime($_POST['endtime'])+3600*24)
			];

			if($this->istest == 'test'){
				$plays = $this->user->test_play($data);
			}else{
				$plays = $this->user->play($data);
			}
			if($plays['code'] == 0){
				foreach($this->user->object2array(json_decode($plays['dataObject'])) as $k=>$v){
					$play[] = $this->user->object2array($v);
					$play[$k]['info'] = $this->user->object2array($v['info']);
				}
				if(count($play)>0){
					print_r($play);
					$this->assign("play",$play);
				}
			}
		}
		//$this->assign("plays",$plays);
		$this->assign("club",$_SESSION['club']);
		$this->render("play_log.tpl");
	}
}