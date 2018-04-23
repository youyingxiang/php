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

class ca_ordersController extends cps_commonController{
	public function indexAction(){
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_agent/ca_orders_list.js");
		 
		//http://www.bootcss.com/p/bootstrap-datetimepicker/ 
		$this->assign("second_menu", "secon_menu.tpl");
		$this->assign("title", '用户成功订单'  );
		$this->assign("agent_view", true  );
		
		$time_from = date("Y-m-d", strtotime( date("Y-m-d") ) - 86400 );
		$time_to = $time_from ;
		$this->assign("js_para", json_encode(array(
			"time_from"=>$time_from ,
			"time_to"=>$time_to ,
			"mygames"=> $_SESSION['mygames'] ,
			"myunions"=> $_SESSION['myunions'] ,
			"agent_id"=> $_SESSION['admin']['id'],
			"agent_view"=> true,
			"ajax"=>"index.php?m=cps_agent&c=ca_orders&a=index_ajax",
			"controller_url"=>"?m=cps_agent&c=ca_orders"
		 )));
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}
	 
	public function index_ajaxAction(){
		 $this->ordersEditorData($_SESSION['myunions']);
	}

	public function orders_calcAction(){
		$result = $this->orders_calc($_SESSION['myunions']);
		echo json_encode($result);
	}
	 
	 
}