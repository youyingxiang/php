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

class cm_rebateController extends cps_commonController{
	public function indexAction(){
		$this->assign("js", "cps_manage/cm_rebate_list.js");
		$this->assign("title", '返利比例'.$this->getRebateDisc() );
		$this->assign("js_privilege", json_encode(array("privilege_code"=>5 )));
		$this->render(false,"common_list.tpl");
	}
	private function getRebateDisc(){
		return "<br><h3><small>返利比例为大于0的浮点型数，如：返利100%则直接填写1</small><br></h3>";
	}
	public function index_ajaxAction(){

		$url = $_SERVER['PHP_SELF'].$_SERVER["QUERY_STRING"];
		$db = Doris\DApp::loadDT();
		
 		$editor = Editor::inst( $db, 'tb_pay_rebate_ratio' ,'id' )
			->fields(
					Field::inst( 'id' ),
				Field::inst( 'channel_id' )
					->options( 'tb_unionlist', 'id', 'name' )
					->validator( 'Validate::notEmpty' ),
				Field::inst( 'channel_code' ),
				Field::inst( 'appid' ),
				Field::inst( 'channel_discount' ),
				Field::inst( 'agent_discount' ),
				Field::inst( 'plattype' ),
				Field::inst( 'open_flag' )

				
			);
		$res = $this->getChildrenAndMyIds($_SESSION['admin']['id']);
		$agent_unions = $this->getAgentsUnions($res);
		$editor->where(function($q) use($agent_unions ) {
			$union_ids = array_keys( $agent_unions );
			$union_ids = implode(",", $union_ids );
			if(!empty($union_ids) ){
				$q->where('channel_id', "( $union_ids) ", 'IN', false);
			}
		});

		// 从iuser增加
		if (in_array(@$_POST['action'] , ['create'] ) ) foreach( $_POST['data'] as $key => $row){
			$channel_id = $_POST['data'][0]['channel_id'];

			//查库
			$sql = "select code,product_id from tb_unionlist where id=".$channel_id;
			$arr = Doris\DDB::fetch($sql );
			$channel_code = $arr['code'];
			$app_id = $arr['product_id'];
			$iuser = _new("Service_IUser");
			$r =  $iuser->addDiscount($_SESSION['admin']['user_name'],$url,$_POST['data'][0]['open_flag'],$channel_id,$channel_code,$app_id,$_POST['data'][0]['channel_discount'],$_POST['data'][0]['plattype']);
			if(@$r[1] != 20000){
				$msg = json_decode($r[4],true);
				$msg = $msg['msg_content']?$msg['msg_content']:"数据同步出错";
				echo '{"error":"'.$msg.'","data":["'.print_r($r).'"]}';exit;
			}
			$_POST['data'][0]['id'] = @$r[3][0]['id'];
			$_POST['data'][0]['channel_code'] = $channel_code;
			$_POST['data'][0]['app_id'] = $app_id;
			//$sql = "INSERT IGNORE INTO `tb_pay_rebate_ratio` ( `id`,`channel_id`,`channel_code`,`appid`,`channel_discount`,`plattype`,`open_flag` ) values ({$r[3][0]['id']},{$_POST['data'][0]['channel_id']},{$_POST['data'][0]['channel_code']},{$_POST['data'][0]['app_id']},{$_POST['data'][0]['channel_discount']},{$_POST['data'][0]['plattype']},{$_POST['data'][0]['open_flag']})";
			//Doris\DDB::execute($sql );

			// 记LOG
			$log_title = "管理员：".$_SESSION['admin']['user_name']." 添加渠道ID：".$row['channel_id']."下的返利配置";

			self::logOperation($log_title,
					["update_rebate"=>$_POST ],
					[],
					"CM_添加返利配置" );
		}

		// 从iuser修改
		if (in_array(@$_POST['action'] , ['edit'] ) ) foreach( $_POST['data'] as $key => $row){
			$channel_id = $row['channel_id'];
			//查库
			$sql = "select code,product_id from tb_unionlist where id=$channel_id";
			$arr = Doris\DDB::fetch($sql );
			$channel_code = $arr['code'];
			$app_id = $arr['product_id'];
			$icenter = _new("Service_IUser");
			$r =  $icenter->upDiscount($_SESSION['admin']['user_name'],$url,$row['id'],$row['channel_id'],$row['channel_code'],$row['appid'],$row['channel_discount']);
			if($r[1] != 20000 ){
				echo '{"error":"调用 iuser 失败","data":["'.print_r($r).'"]}';
				exit;
			}

			// 记LOG
			$log_title = "管理员：".$_SESSION['admin']['user_name']." 修改渠道ID：".$row['channel_id']."下的返利配置";

			self::logOperation($log_title,
					["update_rebate"=>$_POST ],
					[],
					"CM_修改返利配置" );
		}

//		if(in_array(@$_POST['action'] , [ 'edit','create'] ) ) {
//
//			foreach( $_POST['data'] as $key => &$row ){
//
//				// 记LOG
//				$log_title = "管理员：$_SESSION['admin']['user_name'] 修改返利配置";
//
//				self::logOperation($log_title,
//						["update_rebate"=>$_POST ],
//						[],
//						"CM_修改返利配置" );
//			}
//		}

		$editor->process( $_POST ) ->json(); 
	}

 

	
}