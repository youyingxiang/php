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

class rebateController extends cps_commonController{
	private $rebate; //封装game接口对象
	private $count = 3;
	private $rebate_Model;
	private $user_Model;

	public function __construct(){
		parent::__construct();
		$this->rebate_Model = new Mobile_RebateModel();
		$this->user_Model = new Mobile_UserModel();
	}


}