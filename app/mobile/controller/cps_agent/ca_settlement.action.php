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

class ca_settlementController extends cps_commonController{
	public function indexAction(){

		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_agent/ca_settlement.js");
		//http://www.bootcss.com/p/bootstrap-datetimepicker/ 
		$this->assign("second_menu", "secon_menu.tpl");
		$this->assign("title", '我的结算单'  );
		$this->assign("agent_view", true  );
		$this_year = date('Y');
		$this_month = date('m');
		if ($this_month == 1) {
			$last_month = 12;
			$last_year = $this_year - 1;
		} else {
			$last_month = $this_month - 1;
			$last_year = $this_year;
		}
		$time_from = date("Y-m", strtotime("$last_year-$last_month-1") );
		$time_to = date("Y-m",strtotime("$last_year-$this_month-1") ) ;
		$this->assign("js_para", json_encode(array(
			"time_from"=>$time_from ,
			"time_to"=>$time_to ,
			"myunions"=> $_SESSION['myunions'] ,
			"s_status" => array('未结算','申请中','已拒绝','已结算'),
			"agent_id"=> $_SESSION['admin']['id'],
			"agent_view"=> true,
			"ajax"=>"index.php?m=cps_agent&c=ca_settlement&a=index_ajax",
			"controller_url"=>"?m=cps_agent&c=ca_settlement"
		 )));
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}
	 
	public function index_ajaxAction(){
		 $this->settlementEditorData($_SESSION['myunions']);
	}


	public function settlement_calcAction(){
		$result = $this->settlement_calc($_SESSION['myunions']);
		echo json_encode($result);
	}



}