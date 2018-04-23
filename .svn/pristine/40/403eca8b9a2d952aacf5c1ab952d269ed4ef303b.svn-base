<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;


//MARK: 代理商用户管理
/**
 * @Description 代理商用户管理
 * 
 */
 
//Doris\DApp::loadController("common","cps_common");  

class cm_agentController extends cps_commonController{
	public function indexAction(){
	//echo "asd";
		//$this->assign("menu", "cps_manage/menu");
		$a = new TestLib_Test();
		$this->assign("js", "cps_manage/cm_admin_user_list.js");
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 5 )));
		$this->assign("title", _lan('BackgroundUserManagement','CPS代理商管理'));
		$this->render(false,"common_list.tpl");
	}
	static function getEditorInFields($db ,$passSetter, $action = false){ 
	  
		$editor = Editor::inst( $db, 'tb_sys_user',"id" ) 
			->field(
					Field::inst( 'user_name' )->validator( 'Validate::required' ),
					Field::inst( 'id' ),
					Field::inst( 'email')->validator( 'Validate::required' ),
					Field::inst( 'phone'),
					Field::inst('leader'),
					Field::inst('id_no'),
					Field::inst('user_coins'),
					Field::inst('nick_name'),
					Field::inst( 'user_pwd')->validator( 'Validate::required' )
					->setFormatter($passSetter ),
					Field::inst( 'user_level' )
					->options( 'tb_user_level', 'id', 'name' ) 
					->validator( 'Validate::notEmpty' ),

					Field::inst( 'gender')
			); 
		return $editor;
	}
	public function index_ajaxAction(){
		//var_dump($db);
		
		
		//可允许选择的角色在这里配置
		$allowed_role_ids = "31";
		$not_allowed_role_ids = "32"; // CPS管理员
		
		$passSetter =  function ($val, $data, $field) {
							$userinfo = Doris\DApp::newClass( "Admin_AdminModel")->readAdminByName($data['user_name']);
							$old_md5_pass=$userinfo['user_pwd'];
							$new_md5_pass= $val ?md5(md5($val)): $val;
							if($old_md5_pass==$val){
								return $val;//密码未做更改
							}else{
								return $new_md5_pass;
							}
						} ;
					 
		
		$db = Doris\DApp::loadDT();
    	$editor = self::getEditorInFields($db ,$passSetter, @$_POST['action']);
    	
    	$editor ->join(
    			Join::inst( 'tb_sys_user', 'object' )      // Read from 'users' table
    			->aliasParentTable( 'manager' )  // i.e. FROM users as manager
    			->name( 'manager' )              // JSON / POST field
    			->join( 'id', 'leader' )        // Join parent `id`, to child `manager`
    			->set( false )                   // Used for read-only (change the 'manager' on the parent to change the value)
    			->field(
    					Field::inst( 'manager.user_name', 'user_name' )
    			)
    	)
    	// ->join(
    	// 	Join::inst( 'tb_user_level', 'object' )
    	// 	->aliasParentTable( 'user_level' )  // i.e. FROM users as manager
    	// 	->name( 'user_level' )
    	// 	->join( 'id', 'name' )
    	// 	->set(false)
    	// 	->field(
    	// 		Field::inst( 'user_level.name', 'user_level' )
    	// 	) 
    	// )
    	//以下两种关联方式均可
    	->join( //关联方式 1
			Mjoin::inst( 'tb_sys_role' )
				->link( 'tb_sys_user.id', 'tb_sys_user_role.user_id' )
				->link( 'tb_sys_role.id', 'tb_sys_user_role.role_id' )
				->fields(
					Field::inst( 'id' )
						->validator( 'Validate::required' )
						->options( 'tb_sys_role', 'id', 'role_name' ),
					Field::inst( 'role_name' )
				
				) 
		)  
//     	->join( //关联方式 2
//     			Join::inst( 'tb_sys_role', 'array' )
//     			->join(
//     					array( 'id', 'user_id' ),
//     					array( 'id', 'role_id' ),
//     					'tb_sys_user_role'
//     			)
//     			->field(
//     					Field::inst( 'role_name' ),
//     					Field::inst( 'id' )
//     			) 
//     	
//     	)

    	;
    	
    	
    	if( empty( $_POST['action']   ) ) {
			$editor->where(
					function ( $q) use($allowed_role_ids, $not_allowed_role_ids) {
					
						// 限定 CPS Agent
						$subSql = "SELECT u.id FROM tb_sys_user u  inner join tb_sys_user_role ur on  u.id = ur.user_id  WHERE 
										ur.role_id  in ($allowed_role_ids)  ";
						$q->and_where('id', "($subSql) ", 'IN', false); 
					
						// 排除管理员
						$subSql = "SELECT u.id FROM tb_sys_user u  inner join tb_sys_user_role ur on  u.id = ur.user_id  WHERE 
										 ur.role_id  in (  $not_allowed_role_ids )";
						$q->and_where('id', "($subSql) ", 'not IN', false); 
					    // Doris\debugWeb($q); 
					   
					   // 显示用户及所有子用户
					   $all_ids = self::getChildrenAndMyIds($this->getCurrentUserId());
					   $q->and_where('id', "($all_ids) ", 'IN', false);
					   					   
					} 
			); 
    	}
    	
    	//确保角色信息不能为空 		
		if(in_array(@$_POST['action'] , ['edit','create'] ) ) {  
			foreach( $_POST['data'] as $key => &$rowData){
				if( empty($rowData["tb_sys_role"]) ){
					//echo '{"fieldErrors":[{"name":"tb_sys_role","status":"This field is required"}],"data":[]}';
					echo '{"error":"角色不能为空","data":[]}';
					exit;
				}
				 
			}
		}
		
    	
    	//开始处理输出
    	$out = $editor->process($_POST)->data();
    	if ( !isset($_POST['action']) ) { 
    	 	//所有角色列表
    		$out['tb_sys_role'] = Doris\DDB::pdo()->query( "select id as value,role_name as label from tb_sys_role where id in($allowed_role_ids) ")->fetchAll(PDO::FETCH_ASSOC);
    		
    		//Leader只能为当前用户
    		$cur_id =$_SESSION['admin']['id'];
    		$out['userlist']  = Doris\DDB::pdo()->query( "select id as value,user_name as label from tb_sys_user  where id = $cur_id" )->fetchAll(PDO::FETCH_ASSOC);
    		
    		
    	}  
    	
    	echo json_encode($out);
	}

 
	 
	//MARK: 关联渠道
  
    // http://opentool.netkingol.com/index.php?m=cps_manage&c=cm_agent&a=t
    public function tAction(){ 
		//$arr_children = self::getChildrenAndMyIds("1,1,5,5,777,23,6");
		$arr_children = self::getChildrenAndMyIds($this->getCurrentUserId());
		//$arr_children = self::getChildrenAndMyIds("9");
		
		Doris\debugWeb($arr_children);
    }  
	/**
    *@Description 关联渠道权限
    *
    */
    public function relatedUnionAction(){ 
       	$agent_id = $_GET['agent_id'];
        $form_action="?m=cps_manage&c=cm_agent&a=relatedUnion&agent_id=".$agent_id; 
        $userInfo = Doris\DDB::pdo()->query("select user_name,id from tb_sys_user where id = ".$agent_id)->fetch(PDO::FETCH_ASSOC);
        if(!$userInfo){
            $this->error('未找到相关页面','index.php');
        }
        if($_POST){
            if(!$agent_id){
                $this->error("参数不全");
                return false;
            }
            
            //先查一下有没有改过
			$sql = " select  GROUP_CONCAT(DISTINCT(union_id)) union_string from tb_sys_user_union where user_id = {$agent_id} ";
			$union_string = Doris\DDB::pdo()->query($sql)->fetch(PDO::FETCH_ASSOC)["union_string"]; 
			if($union_string != $_POST['the_sels']){
				// 更新用户渠道列表
				Doris\DDB::pdo()->exec("delete from   tb_sys_user_union where user_id =  {$agent_id} ");
				$arrIds = explode(",", $_POST['the_sels']);
				$values_pieces = [];
				foreach ($arrIds as $union_id) { 
					array_push($values_pieces, " ( null, {$agent_id}, {$union_id}  )"); 
				}
				$sql = "insert into  tb_sys_user_union values ".implode(",", $values_pieces);
				Doris\DDB::pdo()->exec( $sql );
    		}
            $this->success('操作成功',$form_action);
            exit;
        } 
        
    	$sql = " select  GROUP_CONCAT(DISTINCT(union_id)) union_string from tb_sys_user_union where user_id = {$agent_id} ";
   	 	$union_string = Doris\DDB::pdo()->query($sql)->fetch(PDO::FETCH_ASSOC)["union_string"]; 
        if( !$union_string){
   	 		$union_string = "";
   	 	}
   	 	
   	 	$sql  = "select  GROUP_CONCAT(DISTINCT(l.`name`)) union_names 
				from tb_unionlist l, tb_sys_user_union ul 
				where l.id = ul.union_id and  ul.user_id = {$agent_id} ";
		$union_names  = Doris\DDB::pdo()->query($sql)->fetch(PDO::FETCH_ASSOC)["union_names"]; 
        $this->unionListAction( $union_string  , "选择渠道<br> <h3><small> 
        	用户名={$userInfo['user_name']} / 用户ID={$userInfo['id']} <br>
        	所有渠道： {$union_names} 
        	</small></h3>" , $form_action, "?m=cps_manage&c=cm_agent");        
    }
    

    private function unionListAction($default ,$title, $form_action ,$back_url){
 
    	$this->assign("js", "cps_manage/cm_unionlist_sel.js");
    	$this->assign("title", $title);
    	$this->assign("form_action", $form_action);//
    	//$this->assign("back", true); 
    	$this->assign("back", $back_url); 
    	$this->assign("js_para", '{default:"'.$default.'"}'); 
    	$this->render(null,"common_list.tpl");
    
    }

    public function union_list_ajaxAction() {
    	$db = Doris\DApp::loadDT();
    	$content=Editor::inst($db, 'tb_unionlist')
    	->fields(
    		Field::inst( 'id' ),
    		Field::inst( 'name' ),
    		Field::inst( 'product_id' ) 
        )
    	->process($_POST)
    	->data();
    	echo json_encode($content);
    }
    
    //MARK: 代理商下属用户订单
	public function ordersAction(){
		$agent_id = $_GET['agent_id'] ;
		$this_url = "index.php?m=cps_manage&c=cm_agent&a=orders";
		$agent_info = self::getAgentInfo($agent_id);
		$this->assign("js", "cps_agent/ca_orders_list.js");
		$this->assign("second_menu", "/cps_agent/ca_orders/secon_menu.tpl");
		
		$sub_title="<br><small><h4>注：只能对玩家一天前的订单进行反提成；
		<br>操作说明：
		【隐藏】代理不可见(尚未实现)
		</h4></small>";
		$this->assign("title", "代理商: <i>$agent_info[user_name], ID:$agent_id</i> 下线用户的订单信息" .$sub_title );
		
		$this->assign("back",true);
		$time_from = date("Y-m-d", strtotime( date("Y-m-d") ) - 86400 );
		$time_to = $time_from ;
		
		$agent_unions = self::getAgentUnions( $agent_id ); 
		$agent_games = self::getUnionGames( $agent_unions ) ;   
		
		$this->assign("js_para", json_encode(array(
			"time_from"=>$time_from ,
			"time_to"=>$time_to ,
			"mygames"=> $agent_games ,
			"myunions"=> $agent_unions ,
			"agent_id"=> $_GET['agent_id'] ,
			"agent_view"=> false,
			"ajax"=>$this_url."_ajax",
			"controller_url"=>"index.php?m=cps_manage&c=cm_agent"
		 )));
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
    
    }
 
    public function orders_ajaxAction() {
    	$agent_id = @$_GET['agent_id'];
    	$agentUnions = self::getAgentUnions($agent_id);
		$this->ordersEditorData( $agentUnions );
    }
	
    public function orders_calcAction() { 
    	$agent_id = @$_GET['agent_id'];
    	$agentUnions = self::getAgentUnions($agent_id);
		$result = $this->orders_calc(  $agentUnions );
		echo json_encode($result);
    }
    
    private function checkOrderCalcResultCommon(&$result){
    	if($result['code'] !==0 ){
			echo json_encode($result);
			exit;
		}
		if(empty($result['data']['rebate'])){ 
			echo json_encode(["code"=>3, "msg"=>"没有返利信息"]);
			exit;
		}
		
		if( $result['data']['rebate']['agent_ratio'] <= 0 ){ 
			echo json_encode(["code"=>4, "msg"=>"提成比例必须大于0"]);
			exit;
		}
		
		if( $result['data']['count'] <= 0){ 
			echo json_encode(["code"=>5, "msg"=>"没有定单"]);
			exit;
		}
		
    }
    // http://opentool.netkingol.com/index.php?m=cps_manage&c=cm_agent&a=orders_onkey_deduct&time_from=2017-02-17&time_to=2017-05-03&agent_id=5&union_id=10080&ot_status=1
    public function orders_onkey_deductAction() {
		if( empty( $_GET["union_id"] ) ){ 
			echo json_encode(["code"=>1, "msg"=>"请选择渠道"]);
			exit;
		}
		 
		$ot_status = @$_GET["ot_status"];
		if( empty( $_GET["ot_status"] ) ||  $_GET["ot_status"] !=1 ){
			echo json_encode(["code"=>2, "msg"=>"请选择未提成订单"]);
			exit;
		}
		 
    	$agent_id = @(int)$_GET['agent_id'];
    	if( empty($agent_id )  ){
			echo json_encode(["code"=>6, "msg"=>"代理商信息有误"]);
			exit;
		}
		
		// 检查时间 
		$logs = [];
		$time_from = @$_GET['time_from'];
		if(!empty( $time_from  )  && @strtotime($time_from) ){
		 	$logs["time_from"]= $time_from ;
		}else{ 
			echo json_encode(["code"=>8, "msg"=>"时间有误"]);
			exit;
		}
		$time_to = @$_GET['time_to'];
		if(!empty( $time_to  )  && @strtotime($time_to) ){
		 	$logs["time_to"]= $time_to;
		}else{ 
			echo json_encode(["code"=>8, "msg"=>"时间有误"]);
			exit;
		}
		
		if(strtotime($time_to) > time() -86400 ){
			echo json_encode(["code"=>9, "msg"=>"只能对一天前的订单返提成"]);
			exit; 
		}
		
    	$agentUnions = self::getAgentUnions($agent_id);
    	// orders_calc 会自动 对agentUnions 和union_id取并
		$result = $this->orders_calc(  $agentUnions ); 
		$this->checkOrderCalcResultCommon($result);
		
		$r = $this->do_deduct(   $agent_id, $result['data']  ,"CM_反提成_多条" ,$logs );
		echo json_encode($r);
		
    }
    
    public function orders_deductAction() {
    	$id = @(int)$_GET['id'];
    	if( empty($id )  ){
			echo json_encode(["code"=>1, "msg"=>"id不能为空"]);
			exit;
		}
    	$agent_id = @(int)$_GET['agent_id'];
    	if( empty($agent_id )  ){
			echo json_encode(["code"=>6, "msg"=>"代理商信息有误"]);
			exit;
		}
		$order_info = Doris\DDB::fetch("select *from tb_pay_orders where id = '$id' " );		 
		if( empty( $order_info["ot_status"] ) ||  $order_info["ot_status"] !=1 ){
			echo json_encode(["code"=>2, "msg"=>"当前处理状态不支持提成"]);
			exit;
		}
		
		if( strtotime($order_info['paid_time'] ) > ( time() - 86400 ) ){
			echo json_encode(["code"=>9, "msg"=>"只能对一天前的订单返提成"]);
			exit; 
		}
		
		$union_id = $order_info['union_id'];
		
		$result = $this->one_order_calc( $id, $agent_id, $union_id ); 
		$this->checkOrderCalcResultCommon($result);
		 
		$r = $this->do_deduct(   $agent_id, $result['data']  ,"CM_反提成" );
		echo json_encode($r);
    }
     
    
    //MARK: 代理商下属用户
    public function usersAction(){
		//$this->assign("menu", "cps_manage/menu");
		$this->assign("js", "cps_agent/ca_users_list.js");
		
		$_SESSION['lagent_id'] = $_GET['agent_id'] ;
		$agent_unions = self::getAgentUnions( $_SESSION['lagent_id'] );
		$agent_games = self::getUnionGames( $agent_unions ) ;   
		
		$this->assign("title", "代理商（ID:".$_SESSION['lagent_id']." ）下线用户");
		$this->assign("js_para", json_encode(array(
			"mygames"=> $agent_games ,
			"myunions"=> $agent_unions,
			"agent_id"=> $_SESSION['lagent_id'],
			"agent_view"=> false,
			"ajax"=>"index.php?m=cps_manage&c=cm_agent&a=users_ajax"
		 )));
		 
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
		$this->render(false,"common_list.tpl");
	}
	 
	public function users_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_game_union_user_reg', 'id' )
			->fields(
				Field::inst( 'game_id' ),
				Field::inst( 'union_id' ),
				//Field::inst( 'child_union_id' ),
				Field::inst( 'ktuid' ),
				Field::inst( 'user_name' ) ->validator( 'Validate::notEmpty' ),
				Field::inst( 'nick_name' ),
				//Field::inst( 'expand_user_name' ),
				//Field::inst( 'email' ),
				Field::inst( 'userphone' ),
				Field::inst( 'reg_time' )
			);

		$agent_id = $_SESSION['lagent_id'] ;
		$agent_unions = self::getAgentUnions( $agent_id );
		$editor->where(function($q) use($agent_unions ) {
		 	$union_ids = array_keys( $agent_unions );
			$union_ids = implode(",", $union_ids );
			if(!empty($union_ids) ){
		 		$q->where('union_id', "($union_ids) ", 'IN', false);
			}else{
				$q->where('union_id', 0, '<');
			}
		 });
		$editor	->process( $_POST )->json();
	}

}