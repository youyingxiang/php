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

class cm_gamesController extends cps_commonController{
	public function indexAction(){
		if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
			$this->error('您没有权限进行此操作','index.php');
			exit;
		}
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_manage/cm_games_list.js");
		//$this->assign("js_para", json_encode(array("privilege_code"=>"n")));
		
		//$this->assign("js_privilege", json_encode(array("privilege_code"=> 5 )));
		 
		$this->assign("title", _lan('BackgroundUserManagement','CPS游戏管理'));
		$this->render(false,"common_list.tpl");
	}
	
	public function index_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$data = Editor::inst( $db, 'tb_games' ,"game_id" )
		->fields(
			Field::inst( 'game_id' )
				->validator( 'Validate::notEmpty' ),
			Field::inst( 'game_name' )
				->validator( 'Validate::notEmpty' ),
			Field::inst( 'game_domain' )
		)
		->process( $_POST )
		->data();
        foreach($data['data'] as $k=>$v){
            $data['data'][$k]['game_operation'] = "<a href='/index.php?m=cps_manage&c=cm_attachment&game_id={$data['data'][$k]['game_id']}'>附件管理</a>";
        }
        echo json_encode($data);	
	}


	//无用
	public function gameListAction(){
		Doris\utf8_header();
		$games = Doris\DDB::pdo()->query( "select game_id as value,game_name as label from tb_games")->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($games);
	}
	
	//cas_menu 的数据：游戏列表
 	// http://opentool.netkingol.com/index.php?m=cps_manage&c=cm_games&a=gameOptionsList
	public function gameOptionsListAction(){
		 
		$ret=['code'=>'fail',"msg"=>"","list"=>[]];
	
		$rootId=@$_GET['rootId'];
		$defaultId=@$_GET['defaultId'];
		if(!$rootId){
			$arrC = Doris\DDB::pdo()->query( "select game_id as value,game_name as label from tb_games")->fetchAll(PDO::FETCH_ASSOC);
			if($arrC && count($arrC) > 0)
				array_push($ret['list'], array("pairs"=>$arrC,"def"=>$defaultId));
		}
		$ret['code']="succ";
		echo json_encode($ret);
	}

}