<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;



/**
 * @Description 管理
 * 
 */

Doris\DApp::loadController("common","cps_common");

class cm_withdrawController extends cps_commonController{
	public function withdrawAction(){
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_manage/cm_withdraw_list.js"); 
		
// 		$agent_unions = self::getAgentUnions($agent_id) ; 
// 		$agent_games =  self::getUnionGames($agent_unions) ; 
// 		  
		$this->assign("js_para", json_encode(array(
			"games"=> $_SESSION['allgames'] ,
			"unions"=> $_SESSION['allunions'] ,
			"agent_view"=> false,
			"controller_url"=>"index.php?m=cps_manage&c=cm_withdraw"
		 )));
		 
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		 
		$this->assign("title", '代理商提现申请');
		$this->render(false,"common_list.tpl");
	}
	// ALTER TABLE `opentool.netkingol.com`.`tb_withdraw` ADD COLUMN `reason` varchar(255) NOT NULL DEFAULT '' AFTER `union_id`;
	public function withdraw_ajaxAction(){
		$db = Doris\DApp::loadDT(); 
		
 		$editor = Editor::inst( $db, 'tb_withdraw','id'  )
			->fields(
				Field::inst( 'agent_id' ) ,
				Field::inst( 'request_time' ) ,
				Field::inst( 'deal_time' ),
				Field::inst( 'status' ),
				Field::inst( 'amount' ),
				Field::inst( 'game_id' ),
				Field::inst( 'union_id' ),
				Field::inst( 'reason' ),
				Field::inst( 'id' ) 
			); 
					
		if(in_array(@$_POST['action'] , [ 'edit','create'] ) ) {
		
			foreach( $_POST['data'] as $key => &$row ){
								
				// 记LOG
				$log_title = "代理商：$agent_id 申请提现";
		
				self::logOperation($log_title,
					 ["withdraw_info"=>$_POST ],
					 [],  
					"CA_申请提现" );
			}
		}
		$editor->process( $_POST ) ->json();
	}
	
	
	/**
	*	拒绝提现
	**/
	public function deny_withdrawAction(){
		$id = @(int)$_GET['id'];
    	if( empty($id )  ){
			echo json_encode( ["code"=>1, "msg"=>"id 不能为空"] ); exit;
		}
		$reason = @$_GET['reason'];
		
 		$withdraw_info = 		Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
 		if( $withdraw_info['status'] != 1) { 
			echo json_encode( ["code"=>3, "msg"=>"当前状态：". $withdraw_info['status']." 不支持本操作"] ); exit;
 		}
		$agent_id = $withdraw_info['agent_id']  ;
		// 更新提现定单状态 
		$now_string = date("Y-m-d H:i:s");
		$sql = "update tb_withdraw set `status` = 3 , deal_time='$now_string' , `reason`='$reason'  where id = '$id'";
		$data = Doris\DDB::execute($sql );
		
		
		$withdraw_info_after = 	Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
		// 记LOG
		$log_title = "拒绝代理商：$agent_id 提现,  提现订单ID：{$id}，原因：{$reason}";
		
		self::logOperation($log_title,
			 ["withdraw_info"=>$withdraw_info ],
			 ["withdraw_info"=>$withdraw_info_after ],  
			"CM_拒绝提现",[ $reason ] ); 
		
		echo json_encode( ["code"=>0, "msg"=>"成功" ]);
	}
	/**
	*	确认完成提现
	**/
	public function confirm_withdrawAction(){
		$id = @(int)$_GET['id'];
    	if( empty($id )  ){
			echo json_encode( ["code"=>1, "msg"=>"id 不能为空"] ); exit;
		}
 
 		$withdraw_info = Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
 		if( $withdraw_info['status'] != 1) { 
			echo json_encode( ["code"=>3, "msg"=>"当前状态：". $withdraw_info['status']." 不能提现"] ); exit;
 		}
 		
		$agent_id = $withdraw_info['agent_id']  ;
		$game_id = $withdraw_info['game_id']  ;
		$union_id = $withdraw_info['union_id']  ;
		$amount = $withdraw_info['amount']  ;
		
 		$agent_info = Doris\DDB::fetch( "select user_coins from tb_sys_user where id = '$agent_id' " ); 
 		 
 		if(  $agent_info['user_coins']  < $amount){
			echo json_encode( ["code"=>2, "msg"=>"平台币余额不足"] ); exit; 
 		}
		
		//开始提现  
		// 减去加平台币
		$sql = "update tb_sys_user set `user_coins` = `user_coins`-'$amount' where id = '$agent_id' ";
		$data = Doris\DDB::execute($sql );
		
		// 更新提现定单状态 
		$now_string = date("Y-m-d H:i:s");
		$sql = "update tb_withdraw set `status` = 4 , deal_time='$now_string' where id = '$id'";
		$data = Doris\DDB::execute($sql );
	 
		$agent_info_after = Doris\DDB::fetch("select user_coins from tb_sys_user where id = '$agent_id' ");
		$withdraw_info_after = Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
		
		// 记LOG
		$log_title = "给代理商：$agent_id 提现：{$amount}， 提现订单ID：{$id}, 更新后平台币：{$agent_info_after['user_coins']}";
		
		self::logOperation($log_title,
			 ["withdraw_info"=>$withdraw_info,"agent_info"=>$agent_info],
			 ["withdraw_info"=>$withdraw_info_after,"agent_info"=>$agent_info_after],  
			"CM_完成提现" ); 
		
		echo json_encode( ["code"=>0, "msg"=>"成功", "data"=> $amount ]);
		
	}
	
}