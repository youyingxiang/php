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

class ca_withdrawController extends cps_commonController{
	public function withdrawAction(){ 
		$this->assign("js", "cps_agent/ca_withdraw_list.js");
		$this->assign("js_para", json_encode(array(
			"games"=> $_SESSION['mygames'] ,
			"unions"=> $_SESSION['myunions'] , 
			"controller_url"=>"index.php?m=cps_agent&c=ca_withdraw",
			 
			"agent_id"=>@(int)$_SESSION['admin']['id'],
			
		 )));
		 
		$cur_coins = $this->currentCoins();
		$this->assign("title", "申请提现<small> 余额：$cur_coins</small>");
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 1 )));
		$this->render(false,"common_list.tpl");
	}
	private function currentCoins(){ 
		$id = @(int)$_SESSION['admin']['id'];
		$user_info = 	Doris\DDB::fetch( "select user_coins from tb_sys_user where id = '$id' " );
		return $user_info['user_coins'];
		
	}
	public function withdraw_ajaxAction(){
		$db = Doris\DApp::loadDT(); 
		$agent_id = @(int)$_SESSION['admin']['id'];
		$cur_coins = $this->currentCoins();
 		$editor = Editor::inst( $db, 'tb_withdraw','id'  )
			->fields(
				Field::inst( 'agent_id' ) ,
				Field::inst( 'request_time' ) ->setFormatter(function ($val, $data, $field) { 
							return date("Y-m-d H:i:s");
						}),
				Field::inst( 'deal_time' )->setFormatter(function ($val, $data, $field) { 
							return date("Y-m-d H:i:s");
						}),
				Field::inst( 'status' )
						->setFormatter(function ($val, $data, $field) { 
							return 1;
						}),
				Field::inst( 'amount' ) 
					->validator( 'Validate::maxNum', array( 'max'=> $cur_coins  ) ),
				Field::inst( 'game_id' ),
				Field::inst( 'union_id' ),
				Field::inst( 'reason' ),
				Field::inst( 'id' ) 
			);
		$editor->where("agent_id",@(int)$_SESSION['admin']['id']);
		
    	
    	//确保角色信息不能为空 		
		if(in_array(@$_POST['action'] , [ 'create'] ) ) {
		
			foreach( $_POST['data'] as $key => &$row ){
				//
				
 				$check = Doris\DDB::fetch( "select count(*)  count from tb_withdraw where agent_id = '$agent_id' and status=1" );
				if( $check['count'] >0 ){
					echo '{"error":"已有申请中的提现订单","data":[]}';
					exit;
				}
				
				
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
	*	取消提现
	**/
	public function cancel_withdrawAction(){
		$agent_id = @(int)$_SESSION['admin']['id'];
    	if( empty($agent_id )  ){
			echo json_encode( ["code"=>1, "msg"=>"代理商登录信息有误"] ); exit;
		}
		
		$id = @(int)$_GET['id'];
    	if( empty($id )  ){
			echo json_encode( ["code"=>1, "msg"=>"id 不能为空"] ); exit;
		}
 
 		$withdraw_info = 		Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
 		 
 		if( $withdraw_info['status'] != 1) { 
			echo json_encode( ["code"=>3, "msg"=>"当前状态：". $withdraw_info['status']." 不支持本操作"] ); exit;
 		} 
		// 更新提现定单状态 
		$now_string = date("Y-m-d H:i:s");
		$sql = "update tb_withdraw set `status` = 2 , deal_time='$now_string' where id = '$id'";
		$data = Doris\DDB::execute($sql );
		
		
		$withdraw_info_after = 	Doris\DDB::fetch( "select * from tb_withdraw where id = '$id' " );
		// 记LOG
		$log_title = "代理商：$agent_id 取消提现,  提现订单ID：{$id}";
		
		self::logOperation($log_title,
			 ["withdraw_info"=>$withdraw_info ],
			 ["withdraw_info"=>$withdraw_info_after ],  
			"CA_取消提现" ); 
		
		echo json_encode( ["code"=>0, "msg"=>"成功" ]);
	}
	 
	
}