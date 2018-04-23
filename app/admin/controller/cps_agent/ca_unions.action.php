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

class ca_unionsController extends cps_commonController{
	public function indexAction(){
		$this->assign("second_menu", "secon_menu.tpl");
		$this->assign("js", "cps_agent/ca_unions_list.js"); 
		
		$this->assign("title", _lan('BackgroundUserManagement','渠道列表'));
		
		//防止管理员增删改（因为管理员一般配置的是模块权限，未能限制到增删改）
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->assign("js_para", json_encode([
			"mygames"=> $_SESSION['mygames'] ,
			"myunions"=>$_SESSION['myunions'] ,
		]));
		//Doris\debugWeb( $_SESSION);
		$this->render(false,"common_list.tpl");
	}
	
	public function index_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_unionlist', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' ),
                Field::inst( 'code' ),
                Field::inst( 'plattype' ),
                Field::inst( 'open_flag' ),
					Field::inst( 'package_url' ),
					Field::inst( 'cdn_url' ),
                Field::inst( 'product_id' )
					->validator( 'Validate::notEmpty' )
            );
		 
		 $editor->where(function($q){
		 	$union_ids = array_keys($_SESSION['myunions']); 
		 	
		 	if($union_ids){
				$union_ids = implode(",", $union_ids );
				$q->where('id', "( $union_ids) ", 'IN', false);
			}else{
				$q->where('id', "-1" )->and_where('id', "-2"); 
			}
		 });

		if( !empty($_GET['game_id']) ){
			$editor->where("product_id",$_GET['game_id']);
		}
		
		$editor->process( $_POST ) ->json();
		
	}

 
	public function fetchUnionlistAction(){
		$ret=['code'=>'1',"msg"=>"","data"=>null];
		//TODO: 去service拉取列表
		sleep(5);
		
		$ret['code'] = 0 ; 
		$ret['data']  = $_GET;
		echo json_encode($ret);
	}
 
	
}