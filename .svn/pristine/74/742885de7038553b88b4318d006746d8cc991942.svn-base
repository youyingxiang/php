<?php 
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;



use Doris\DApp;

class cps_commonController extends  commonController{

	//MARK: 构造函数（存储SESSION）==============================
	public function __construct(){
		parent::__construct();
		
		$this->sessionUserData();
		
	}
	
	//
	/*
	*	把全局字典加到SESSION里去
	*	游戏、渠道、用户游戏、用户渠道  
	*/
	public function sessionUserData(  ){
		$user_id = $_SESSION['admin']['id'];
	 	$_SESSION['mygames'] = [];
	 	$_SESSION['myunions'] = [];
	 	$_SESSION['allgames'] = [];
	 	$_SESSION['allunions'] = [];
		if($this->hasPrivilege("cps_agent","ca_unions")){
			$_SESSION['myunions'] = self::getAgentUnions( $user_id ); 
			$_SESSION['mygames']  = self::getUnionGames( $_SESSION['myunions'] );
		}
		
		if($this->hasPrivilege("cps_manage")){
			$_SESSION['allunions'] = Doris\DDB::pdo()->query( "select id as value, name as label from tb_unionlist  " )->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
			self::simplifyColumnGroup($_SESSION['allunions'] ); 
			
			$_SESSION['allgames']  = Doris\DDB::pdo()->query( "select game_id as value,game_name as label from tb_games  " )->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
			self::simplifyColumnGroup($_SESSION['allgames'] );
		}
		
		//Doris\debugWeb($_SESSION);
	}
	
	
	
	//MARK: 工具函数==============================
	/*
	*		获取agent_id对应的渠道
	*		返回：
	*			返回示例：[10080=>"Chanel1", 10081=>"Chanel2"]  
	*			其中key为渠道id, VALUE为渠道名
	*
	*/
	public static function getAgentUnions($agent_id){
		$unions = [];
		$sql = "select id , name  from tb_unionlist where id in (select union_id from tb_sys_user_union where user_id = '$agent_id' )" ;
		$unions = Doris\DDB::pdo()->query( $sql )->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
		self::simplifyColumnGroup($unions );
		return $unions ;
	}

	/*
	*		获取agent_id对应的渠道(修改)
	*		返回：
	*			返回示例：[10080=>"Chanel1", 10081=>"Chanel2"]
	*			其中key为渠道id, VALUE为渠道名
	*
	*/
	public static function getAgentsUnions($agent_id){
		$unions = [];
		$sql = "select id , name  from tb_unionlist where id in (select union_id from tb_sys_user_union where user_id in ($agent_id) )" ;
		$unions = Doris\DDB::pdo()->query( $sql )->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
		self::simplifyColumnGroup($unions );
		return $unions ;
	}
	
	/*
	*		获取unions对应的游戏
	*		参数unions 
	*			为 getAgentUnions 返回的数据类型
	*		返回：
	*			返回示例：[520001=>"游戏1", 520002=>"游戏2"]  
	*			其中key为游戏id, VALUE为游戏名
	*/
	public static function getUnionGames($unions){ 
		$games = [];
		$union_ids = array_keys($unions);
		$union_ids = implode(",", $union_ids );
		if($union_ids){
			$sql = "select game_id as value,game_name as label from tb_games where game_id in (select product_id from tb_unionlist where id in ($union_ids) )" ;
			$games = Doris\DDB::pdo()->query( $sql)->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
			self::simplifyColumnGroup( $games  );
		}
		return $games ;
	}
	 
	/*
	*		获取Agent用户信息(即系统用户)
	*/
	public static function getAgentInfo($agent_id){  
		$sql = "select * from tb_sys_user  where id = '$agent_id'" ; 
		 return  Doris\DDB::pdo()->query( $sql)->fetch( ); 
	 
	}
	
	/*
	*	记录操作日志
	*/
	public static function logOperation($title,$camera,$newcamera,$type = "default",$log=[]){
		_load( "Admin_ActionLogModel");
		$detail['camera'] = $camera;
		$detail['newcamera'] = $newcamera;
		$detail['log']=$log;
		Admin_ActionLogModel::logging($title,$detail,$type,$category="cps");
	 
	}
	
	//MARK: 共用的一些Editor请求==============================
	/*
	*	订单的Ajax请求
	*	入参：
	*		union_pairs 为 getAgentUnions 返回的数据类型
	*		agent_view 代理商视角，还是管理员视角
	*/
	public function ordersEditorData( $union_pairs ,$agent_view = true){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_order', 'id' )
			->fields( 
				Field::inst( 'id' ),
				Field::inst( 'order_id' ),
				Field::inst( 'user_name' ),
				Field::inst( 'channel_id' ),
				Field::inst( 'payOrderTime' ),
				Field::inst( 'userip' ),
				Field::inst( 'amount' ),
				Field::inst( 'union_id' ),
				Field::inst( 'extendbox' ),
				Field::inst( 'productID' ),
				Field::inst( 'serverID' ),
				Field::inst( 'settle_status' )
			);
		$editor	->where("payState",3);

		$editor	->where("amount",0,">");
		$editor->where(function($q) use ($union_pairs){
		 	$union_ids = array_keys($union_pairs);
		 	if($union_ids){
				$union_ids = implode(",", $union_ids );
				$q->where('union_id', "( $union_ids) ", 'IN', false);
			}else{
				$q->where('union_id', "-1" )->and_where('union_id', "-2");
			}
		 });

		if(!empty($_GET["settle_status"])){

			$editor	->where("settle_status",$_GET["settle_status"]);
		}else{
			$editor	->where("settle_status",0);
		}

		if(!empty($_GET["union_id"])){
			$union_id = $_GET["union_id"];

			$editor	->where("union_id", $union_id);
		}
		if(!empty($_GET['time_from'] ) && @$_GET['time_from'] ){

			$editor	->where("payOrderTime", $_GET['time_from'] ,">=");
		}

		if(!empty($_GET['time_to'] ) && @$_GET['time_to'] ){
			$time_to = $_GET['time_to'];
		 	if(strlen($time_to) < 12){ //转成长时间格式
		 		$time_to .= " 23:59:59";
		 	}
			$editor	->where("payOrderTime", $time_to ,"<=");
		}
		$editor	->process( $_POST )->json();
	}

	public function appordersEditorData( $settlement_id,$union_pairs ,$agent_view = true){
		$db = Doris\DApp::loadDT();
		$editor = Editor::inst( $db, 'tb_order', 'id' )
				->fields(
						Field::inst( 'id' ),
						Field::inst( 'order_id' ),
						Field::inst( 'ktuid' ),
						Field::inst( 'payOrderTime' ),
						Field::inst( 'amount' ),
						Field::inst( 'transaction_id' ),
						Field::inst( 'settlement_id' ),
						Field::inst( 'extendbox' ),
						Field::inst( 'union_id' ),
						//Field::inst( 'settle_status' ),
						Field::inst( 'productID' )
// 				Field::inst( 'server_id' )
				);
		$editor	->where("amount",0,">");
		$editor->where(function($q) use ($union_pairs){
			$union_ids = array_keys($union_pairs);
			if($union_ids){
				$union_ids = implode(",", $union_ids );
				$q->where('union_id', "( $union_ids) ", 'IN', false);
			}else{
				$q->where('union_id', "-1" )->and_where('union_id', "-2");
			}
		});

		if(!empty($_GET["union_id"])){
			$union_id = $_GET["union_id"];
			$editor	->where("union_id", $union_id);
		}
		if(!empty( $settlement_id ) ){
			$editor	->where("settlement_id",$settlement_id,'=');
		}
		$editor	->process( $_POST )->json();
	}

	public function apporder_calc( $settlement_id,$union_pairs ,$m,$agent_view = true){
		$where = " where tb_order.payState=3 ";
		$union_ids = array_keys($union_pairs);
		if($union_ids){
			$union_ids = implode(",", $union_ids );
			$where .= " and tb_order.union_id in ($union_ids)";
		}else{
			$where .= " and 1=-1 "; //表明用户没有渠道
		}

		$union_id = @$_GET["union_id"];
		if(!empty( $union_id ) ){
			$where .= " and tb_order.union_id = '$union_id' ";
		}

		if(!empty( $settlement_id ) ){
			$where .= " and tb_order.settlement_id = '$settlement_id' ";
		}

		$sql = "select sum(tb_order.amount) amount,count(*)  count , GROUP_CONCAT(DISTINCT(tb_order.order_id)) oids,tb_settlement.s_status,tb_settlement.settlement_id from tb_order left join tb_settlement on tb_order.settlement_id=tb_settlement.settlement_id $where";
		//return $sql;
		// 结算单统计信息
		$data = Doris\DDB::fetch($sql);
		//return ["code"=>0, "msg"=>"", "data"=>$sql] ;
		#0：未结算；1：申请中；2：已拒绝；3：已结算
		if($data['s_status']==0){
			$data['s_status'] = '未结算';
		}else if($data['s_status']==1){
			//$action = @$_GET["m"];
			//$data['action'] = $action;
			$sel_role = Doris\DDB::fetch('select role.role_id as role from tb_sys_user as user left join tb_sys_user_role as role on user.id=role.user_id where user.id='.$_SESSION['admin']['id']);
			//$sel_role['role']==1    权限条件
			if($_GET['rm'] == 'cps_manage'){
				//$data['s_status'] = "申请中,<a href=index.php?m=cps_manage&c=cm_settlement&a=confirm_settlement&settlement_id=".$data['settlement_id'].">结算</a>";
				//$data['s_status'] = "申请中,<a href='javascript:void(0)' onclick='doOption('confirm_settlement,'".$_SESSION['admin']['id']."')'>结算</a>";

				$data['s_status'] = '申请中,<a href="javascript:void(0)" onclick="settle('.$data["settlement_id"].')">结算</a>';
			}else{
				$data['s_status'] = "申请中";
			}
		}else if($data['s_status']==2){
			$data['s_status'] = '已拒绝';
		}else if($data['s_status']==3){
			$data['s_status'] = '已结算';
		}

		$sqlo = "select  uorder.order_id,uorder.amount,ratio.agent_discount from tb_order as uorder left join tb_sys_user_union as unoins on uorder.union_id=unoins.union_id left join tb_pay_rebate_ratio as ratio on unoins.union_id=ratio.channel_id where unoins.user_id=".$_SESSION['admin']['id']." and uorder.settlement_id=".$settlement_id;

		$order = Doris\DDB::fetchAll($sqlo );
		$data['deduct'] = 0;
		foreach($order as $v){
			$data['deduct'] += $v['amount'] * $v['agent_discount'];
		}

		$udata = Doris\DDB::fetch($sql);
		$data['user_coins']=empty($udata['user_coins'])? 	0: $udata['user_coins'];
		//return $udata['user_coins'];
		return ["code"=>0, "msg"=>"", "data"=>$data] ;
	}

	//MARK: 共用的一些Editor请求==============================
	/*
	*	结算单的Ajax请求
	*
	*/

	public function settlementEditorData( $union_pairs ,$agent_view = true){
		$db = Doris\DApp::loadDT();
		$editor = Editor::inst( $db, 'tb_settlement', 'settlement_id' )
				->fields(
						//Field::inst( 'settlement_id' ),
						Field::inst( 'start_time' ),
						Field::inst( 'end_time' ),
						Field::inst( 'settlement_no' ),
						Field::inst( 'settlement_amount' ),
						Field::inst( 's_status' ),
						Field::inst( 'refuse_msg' )
						//Field::inst( 'application_time' ),
						//Field::inst( 'processing_time' )

				);
		$s_status = @$_GET["s_status"];
		if(!empty( $s_status ) ){
			$editor	->where("s_status", $s_status);
		}
		if(!empty($_GET['time_from'] )){
			$editor	->where("start_time", $_GET['time_from']  ,">=");
		}
		if(!empty($_GET["union_id"])){
			$union_id = $_GET["union_id"];

			$editor	->where("union_id", $union_id);
		}

		if(!empty($_GET['time_to'] )){
			$time_to = $_GET['time_to'];
			$editor	->where("end_time", $time_to ,"<=");
		}
		$editor	->process( $_POST )->json();
	}

	public function settlement_calc($union_pairs ,$agent_view = true){

		$where = "";

		$s_status = @$_GET["s_status"];
		if(!empty( $s_status ) ){
			$where .= " s_status = $s_status ";
		}
		if(!empty($_GET['time_from'] ) && @strtotime($_GET['time_from'] ) ){
			$where .= " and start_time >= '".$_GET['time_from']."' ";
		}
		$union_id = @$_GET["union_id"];
		if(!empty( $union_id ) ){
			$where .= " and union_id = '$union_id' ";
		}


		if(!empty($_GET['time_to'] ) && @strtotime($_GET['time_to'] ) ){
			$time_to = $_GET['time_to'];
			$where .= " and end_time <= '". $time_to ."' ";
		}

		$sql = "select * from tb_settlement where $where";
		// 结算单统计信息
		$data = Doris\DDB::fetch($sql);
		//return ["code"=>0, "msg"=>"", "data"=>$sql] ;
		//读取用户剩余平台币：
		$agent_id = @(int)$_GET['agent_id'];
		if( empty($agent_id )  ){
			echo json_encode(["code"=>6, "msg"=>"代理商信息有误"]);
			exit;
		}

		$sql = "select user_coins from tb_sys_user where id = $agent_id ";
		$udata = Doris\DDB::fetch($sql);
		$data['user_coins']=empty($udata['user_coins'])? 	0: $udata['user_coins'];
		//return $udata['user_coins'];
		return ["code"=>0, "msg"=>"", "data"=>$data] ;
	}

	// http://opentool.netkingol.com/index.php?m=cps_manage&c=cm_agent&a=orders_calc&time_from=2017-01-04&time_to=2017-05-02&agent_id=5&union_id=10080&op_status=1
	// 如果 agent_view=true 则只显示 ot_status 小于10的状态
	public function orders_calc( $union_pairs ,$agent_view = true){
		$where = " where";
		$union_ids = array_keys($union_pairs);
		if($union_ids){
			$union_ids = implode(",", $union_ids );
			$where .= " uorder.union_id in ($union_ids)";
		}else{
			$where .= " 1=-1 "; //表明用户没有渠道
		}
		if(!empty( $union_id ) ){
			$where .= " and uorder.union_id = '$union_id' ";
		}

		if(!empty($_GET['settle_status'] ) ){
			$where .= " and uorder.settle_status=".$_GET['settle_status'];
		}else{
			$where .= " and uorder.settle_status=0";
		}
		if(!empty($_GET['time_from'] ) ){
			$where .= " and uorder.payOrderTime >= '".date('Y-m-d',strtotime($_GET['time_from'] ))."' ";
		}

		if(!empty($_GET['time_to'] ) && @strtotime($_GET['time_to'] ) ){
			$time_to = $_GET['time_to'];
			$where .= " and uorder.payOrderTime < '". date('Y-m-d',strtotime($time_to)) ."' ";
		}
		$where .= " and uorder.payState=3 and uorder.payState>0";

		
		// 计算返利信息 agent_ratio  	ratio	deduct
		if(!empty( $union_id ) ){
			$where .= "  channel_id = '$union_id' ";
		}


			$sql = "select  uorder.order_id,uorder.amount,ratio.agent_discount from tb_order as uorder left join tb_sys_user_union as unoins on uorder.union_id=unoins.union_id left join tb_pay_rebate_ratio as ratio on unoins.union_id=ratio.channel_id $where and unoins.user_id= ".$_SESSION['admin']['id'];
			$order = Doris\DDB::fetchAll($sql );
			$data = ['deduct'=>0,'amount'=>0,'count'=>count($order),'oids'=>''];
			foreach($order as $v){
				$data['deduct'] += $v['amount'] * $v['agent_discount'];
				$data['amount'] += $v['amount'];
				$data['oids'] .= $v['order_id'].',' ;
			}
		$data['oids'] = trim($data['oids'],',');
		
		//读取用户剩余平台币：
		$agent_id = @(int)$_GET['agent_id'];
    	if( empty($agent_id )  ){
			echo json_encode(["code"=>6, "msg"=>"代理商信息有误"]);
			exit;
		}
		
		$sql = "select user_coins from tb_sys_user where id = '$agent_id' ";
		$udata = Doris\DDB::fetch($sql );
		$data['user_coins']=empty($udata['user_coins'])? 0: $udata['user_coins'];
		return ["code"=>0, "msg"=>"", "data"=>$data] ;
	}
	 
	/*
	* 单条计算
	*/
	public function one_order_calc( $id, $agent_id, $union_id  ,$agent_view = true){
		$sql = "select sum(pay_amount) amount,count(*)  count , GROUP_CONCAT(DISTINCT(order_id)) oids from tb_pay_orders where id = '$id' ";
		// 订单统计信息
		$data = Doris\DDB::fetch($sql );
		if(!$data['amount']){
			$data['amount'] = 0;
		}
		
		// 计算返利信息 agent_ratio  	ratio	deduct 
		if(!empty( $union_id ) ){
			$sql = "select game_id , union_id , ratio , agent_ratio from tb_pay_rebate_ratio where union_id = '$union_id' ";
			$rebate = Doris\DDB::fetch($sql );
			$data['rebate'] = $rebate;
			$data['deduct'] = $data['amount'] *  $rebate['agent_ratio'] / 100 ;
		}
		
		//读取用户剩余平台币：
		
		$sql = "select user_coins from tb_sys_user where id = '$agent_id' ";
		$udata = Doris\DDB::fetch($sql );
		$data['user_coins']=empty($udata['user_coins'])? 	0: $udata['user_coins'];
		return ["code"=>0, "msg"=>"", "data"=>$data] ;
	}
	
	
	/*
	* 执行返利
	*/
	public function do_deduct(   $agent_id, $stat_data  ,$logtype , $logs = [] ){ 
		
		$rebate = $stat_data['rebate'];
		
		//执行返提成、更新所有涉及的订单
		$agent_ratio = $rebate['agent_ratio'];
		$deduct = $stat_data['deduct'];
		// 加平台币
		$sql = "update tb_sys_user set `user_coins` = `user_coins`+'$deduct' where id = '$agent_id' ";
		$data = Doris\DDB::execute($sql );
		// 更新订单
		$oids = $stat_data['oids'];
		$oids = "'".str_replace(",","','",$oids)."'";
		$sql = "update tb_pay_orders set `ot_status` = 2 where order_id in ($oids)";
		$data = Doris\DDB::execute($sql );
		$sql = "select user_coins from tb_sys_user where id = '$agent_id' ";
		$udata = Doris\DDB::fetch($sql );
		
		// 记LOG
		$log_title = "给代理商：$agent_id 添加平台币：{$stat_data['deduct']}，订单总额：{$stat_data['amount']}，更新后平台币：{$udata['user_coins']}";
		self::logOperation($log_title, $stat_data, $udata, $logtype ,$logs);
		//Doris\debugWeb([ $log_title , $stat_data,$udata]);
		
		return ["code"=>0, "msg"=>"成功", "data"=> $udata ];
	}


	public function order_d($agent_id,$settlement_id='',$m=''){
		$this_url = "index.php?m=cps_agent&c=ca_apply&a=orders";
		$agent_info = self::getAgentInfo($agent_id);
		$this->assign("js", "cps_agent/ca_apporders_list.js");
		$this->assign("second_menu", "/cps_agent/ca_apply/secon_menu.tpl");
		$this->assign("title", "代理商: <i>$agent_info[user_name], ID:$agent_id</i> 结算单下用户的订单信息" );

		$this->assign("back",true);
		$agent_unions = self::getAgentUnions( $agent_id );
		$agent_games = self::getUnionGames( $agent_unions ) ;

		$this->assign("js_para", json_encode(array(
				"mygames"=> $agent_games ,
				"m"=> $m ,
				"myunions"=> $agent_unions ,
				"agent_id"=> $agent_id ,
				"agent_view"=> false,
				"ajax"=>$this_url."_ajax",
				"controller_url"=>"index.php?m=cps_agent&c=ca_apply"
		)));
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}

	public function order_dshow($agent_id,$start_time){
		$this_url = "index.php?m=cps_agent&c=ca_apply&a=orders";
		$agent_info = self::getAgentInfo($agent_id);
		$this->assign("js", "cps_agent/ca_apporders_list.js");
		$this->assign("second_menu", "/cps_agent/ca_apply/secon_menu.tpl");
		$this->assign("title", "代理商: <i>$agent_info[user_name], ID:$agent_id</i> 结算单下用户的订单信息" );

		$this->assign("back",true);
		$agent_unions = self::getAgentUnions( $agent_id );
		$agent_games = self::getUnionGames( $agent_unions ) ;

		$this->assign("js_para", json_encode(array(
				"mygames"=> $agent_games ,
				"myunions"=> $agent_unions ,
				"agent_id"=> $agent_id ,
				"agent_view"=> false,
				"ajax"=>$this_url."_ajax",
				"controller_url"=>"index.php?m=cps_agent&c=ca_apply"
		)));
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}

	public function ordertable($start_time,$union_pairs){
		$db = Doris\DApp::loadDT();
		$editor = Editor::inst( $db, 'tb_order', 'id' )
				->fields(
						Field::inst( 'id' ),
						Field::inst( 'order_id' ),
						Field::inst( 'ktuid' ),
						Field::inst( 'payOrderTime' ),
						Field::inst( 'amount' ),
						Field::inst( 'transaction_id' ),
						Field::inst( 'settlement_id' ),
						Field::inst( 'extendbox' ),
						Field::inst( 'union_id' ),
						Field::inst( 'settle_status' ),
						Field::inst( 'productID' )
// 				Field::inst( 'server_id' )
				);
		$editor	->where("amount",0,">");
		$editor	->where("settle_status", 0,"=");
		$editor->where(function($q) use ($union_pairs){
			$union_ids = array_keys($union_pairs);
			if($union_ids){
				$union_ids = implode(",", $union_ids );
				$q->where('union_id', "( $union_ids) ", 'IN', false);
			}else{
				$q->where('union_id', "-1" )->and_where('union_id', "-2");
			}
		});

		if(!empty($_GET["union_id"])){
			$union_id = $_GET["union_id"];
			$editor	->where("union_id", $union_id);
		}
		if(!empty( $start_time ) ){
			$editor	->where("payOrderTime",date('Y-m-d',strtotime($start_time)),'>=');
			$editor	->where("payOrderTime",date('Y-m',strtotime($start_time))."-32",'<');
		}
		$editor	->process( $_POST )->json();
	}
}