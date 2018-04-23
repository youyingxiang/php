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

class cm_ordersController extends cps_commonController{
	public function indexAction(){
//
//		$res = $this->getChildrenAndMyIds($_SESSION['admin']['id']);
//		$agent_unions = $this->getAgentsUnions($res);
//		print_r($agent_unions);die;
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_manage/cm_orders_list.js"); 
		
		$this->assign("title", '用户订单'  );
		$this->assign("second_menu", "secon_menu.tpl");
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		
		$time_to =  date("Y-m-d H:i:s",time());
		$time_from =    date("Y-m-d H:i:s", strtotime($time_to)  - 86400 ) ;
		$this->assign("js_para", json_encode(array("time_from"=>$time_from ,"time_to"=>$time_to  )));
		$this->render(false,"common_list.tpl");
	}
	 
	public function index_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_order', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'order_id' ),
				Field::inst( 'ktuid' ),
				Field::inst( 'payOrderTime' ),
				Field::inst( 'amount' ),
				Field::inst( 'payState' ),
				Field::inst( 'transaction_id' ),
				//Field::inst( 'card_no' ),
				Field::inst( 'union_id' ), 
				Field::inst( 'productID' ),
				Field::inst( 'serverID' ) ,
				Field::inst( 'extendbox' )
			);
		$res = $this->getChildrenAndMyIds($_SESSION['admin']['id']);
		$agent_unions = $this->getAgentsUnions($res);
		$editor->where(function($q) use($agent_unions ) {
			$union_ids = array_keys( $agent_unions );
			$union_ids = implode(",", $union_ids );
			if(!empty($union_ids) ){
				$q->where('union_id', "( $union_ids) ", 'IN', false);
			}
		});

		if ( !isset($_POST['action']) ) {
			if(!empty($_GET['time_from'] ) ){
				$editor	->where("payOrderTime", date('Y-m-d',strtotime($_GET['time_from'] )) ,">=");
			}
		
			if(!empty($_GET['time_to'] ) && @strtotime($_GET['time_to'] ) ){
				$editor	->where("payOrderTime", date('Y-m-d',strtotime($_GET['time_to'] )) ,"<=");
			}
		}

		$editor	->process( $_POST )->json();
	}

	 
}