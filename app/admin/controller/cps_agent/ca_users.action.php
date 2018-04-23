<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;



/**
 * @Description  
 * 
 */

Doris\DApp::loadController("common","cps_common");

class ca_usersController extends cps_commonController{
	public function indexAction(){
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_agent/ca_users_list.js"); 
		
		$this->assign("title", '我的用户' );
		$this->assign("js_para", json_encode(array(
			"mygames"=> $_SESSION['mygames'] ,
			"myunions"=> $_SESSION['myunions'] ,
			"agent_id"=> $_SESSION['admin']['id'],
			"agent_view"=> true,
			"ajax"=>"index.php?m=cps_agent&c=ca_users&a=index_ajax"
		 )));
		 
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}
	 
	public function index_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_game_union_user_reg', 'id' )
			->fields(
				Field::inst( 'ktuid' ),
				Field::inst( 'user_name' ) ->validator( 'Validate::notEmpty' ),
				Field::inst( 'nick_name' ),
				Field::inst( 'cps_channel' ),
				Field::inst( 'userphone' )
			);
		$editor->where(function($q){
		 	$union_ids = array_keys($_SESSION['myunions']);
			$union_ids = implode(",", $union_ids );
			if(!empty($union_ids) ){
		 		$q->where('union_id', "( $union_ids) ", 'IN', false);
			}
		 });
		$editor	->process( $_POST )->json();
	}



	//MARK: 几个ICenter的测试
	/** ICenter 测试——拉取用户
 	* 	测试前保留下测试数据：
 	*	http://icenter.netkingol.com/iuserplat_test?k&d
	* 	测试
	*	http://opentool.netkingol.com/index.php?m=cps_agent&c=ca_users&a=test_users
	**/ 
	public function test_usersAction(){
		$icenter = _new("Service_ICenter");
		//list($recvedOK,$recvCode,$recvMsg,$recvData,$raw ) 
		$union_id= "99999999";
		$since = strtotime(  "2017-04-25 10:00:00" ) ;
        $time_to = strtotime(  "2017-04-28 10:00:00" ) ;
		
		$r = $icenter->unionUsersGet(
			$since,  $time_to, $union_id
		);
		Doris\debugWeb($r );
	}
	
	
	
	/** ICenter 测试——拉取渠道
 	* 	测试前保留下测试数据：
 	*	http://icenter.netkingol.com/iunion_test?k&d
	* 	测试
	*	http://opentool.netkingol.com/index.php?m=cps_agent&c=ca_users&a=test_unions
	**/ 
	public function test_unionsAction(){
		$iuser = _new("Service_IUser");
		extract([
				'game_id' => "99999999",
				'password' => "123qwe",
				'since_id' => -2 , 
				'user_name' => "admin_icenter_test",
		]);
		$r = $iuser->unionListGet($user_name, $password , $since_id ,$game_id  );
		Doris\debugWeb($r );
	}
	
	
	/** ICenter 测试——拉取订单
 	* 	测试前保留下测试数据：
 	*	http://icenter.netkingol.com/iorder_test?k&d
	* 	测试：
	*	http://opentool.netkingol.com/index.php?m=cps_agent&c=ca_users&a=test_orders
	**/
	public function test_ordersAction(){
		$iuser = _new("Service_IUser");
		
		extract([
			'game_id' => false,//"520006",
			'since' => strtotime(  "2017-01-25 10:00:00" ) , 
			'time_to' => strtotime(  "2017-04-27 20:00:00" ) , 
			'union_id' =>false,// "99999999"
		]);
		
		$r = $iuser->orderListAction($since, $time_to,$game_id  ,$union_id   );
		Doris\debugWeb($r );
	}
}