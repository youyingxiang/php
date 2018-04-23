<?php
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Validate;

/**
 * @Description 操作日志管理
 * 
 */

class cm_actionlogController extends commonController {
	public function indexAction(){
		if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
			$this->error('您没有权限进行此操作','index.php');
			exit;
		}
		$this->assign("js", "cps_manage/cm_actionlog_list.js");		
		$this->assign("menu", "index/sys_menu");
		$this->assign("js_para",json_encode( [ "type_list" => $this->get_type_list()] ) );
		$this->assign("title", _lan('OperationLog','操作日志')	);
		$this->render(false,"common_list.tpl");
	}
	
	public function index_ajaxAction(){
        $db = Doris\DApp::loadDT();
    	$editor = Editor::inst( $db, 'tb_sys_action_log' )
    	->field(
    			Field::inst( 'id' ),
    			Field::inst( 'user_name' ), 
    			Field::inst( 'type' ),
    			Field::inst( 'title'), 
    			Field::inst( 'time') 
    	); 
    	$editor->where("category","cps");
    	$out = $editor->process($_POST)->data();
    	 
    	echo json_encode($out);
    
	}

    public function browseLogDetailAction(){
        $logInfo = Doris\DApp::newClass( "Admin_ActionLogModel")->readActionLogById($_GET['id']);
        if(!$logInfo){$this->error('未找到相关数据','?m=cps_manage&c=cm_actionlog');}
        $this->assign("title", '查看操作日志详情' );
        $this->assign('loginfo',$logInfo);
        
		$this->render("/admin/action_log/browseLogDetail.tpl","main.tpl"); 
        
    }

    public function delLogAction(){
        $issuc = (new Admin_ActionLogModel())->delLog($_GET['id']);
        $this->success("操作成功",-1);
        
    }

    public function get_type_list(){
		$sql = "select DISTINCT type, type from tb_sys_action_log where category='cps'" ;
		$results = Doris\DDB::pdo()->query( $sql )->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
		self::simplifyColumnGroup($results ); 
		return $results ;
		 
	}

 

	
}