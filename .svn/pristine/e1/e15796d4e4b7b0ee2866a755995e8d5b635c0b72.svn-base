<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;





/**
 * @Description 游戏附件管理
 * 
 */
Doris\DApp::loadController("common","cps_common");
class cm_attachmentController extends cps_commonController{
    public function indexAction(){
		$this->assign("js", "cps_manage/cm_game_attachment_list.js");		
		$this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
        $this->assign("js_para", json_encode(array("game_id"=>$_GET['game_id'])));
        $this->assign("second_menu", "/cps_manage/cm_attachment/attachment_second_menu.tpl");
        _load( "Admin_GameModel");
		$game_info = Admin_GameModel::readGameById(@$_GET['game_id']);
        if(!$game_info){$this->error('游戏未找到','index.php?m=cps_manage&c=cm_games');exit;}
		$this->assign("title", _lan('BackgroundUserManagement','游戏附件管理'));
        $this->assign('sub_title',"&nbsp;游戏:{$game_info['game_name']} — {$game_info['game_id']}");
		$this->render(false,"common_list.tpl");
    }

    public function index_ajaxAction(){
	    $db = Doris\DApp::loadDT();
	    $editor = Editor::inst( $db, 'tb_attachment' )
	    ->field(
	    	Field::inst( 'id' ),
	    	Field::inst( 'name' ),
	    	Field::inst( 'remark' ),
	    	Field::inst( 'path' ),
	    	Field::inst( 'version' ),
	    	Field::inst( 'type' )
	    )->where("game_id",$_GET['id']);
        $out = $editor->process($_POST)->data();
        _load( "Admin_PrivilegeModel");
        $privilegeModel = new Admin_PrivilegeModel();
        foreach($out['data'] as $k=>$v){
            $out['data'][$k]['operation'] = '';
            if($privilegeModel->checkAuth('cps_manage','cm_attachment','viewAttachment')){
                $out['data'][$k]['operation'] .= '<a href="?m=cps_manage&c=cm_attachment&a=viewAttachment&id='.$v['id'].'">查看附件</a>&nbsp;&nbsp;';
            }
            if($privilegeModel->checkAuth('cps_manage','cm_attachment','updateAttachment')){
                $out['data'][$k]['operation'] .= '<a href="?m=cps_manage&c=cm_attachment&a=updateAttachment&id='.$v['id'].'">修改附件</a>&nbsp;&nbsp;';
            }
            if($privilegeModel->checkAuth('cps_manage','cm_attachment','delAttachment')){
                $out['data'][$k]['operation'] .= '<a href="?m=cps_manage&c=cm_attachment&a=delAttachment&id='.$v['id'].'" onclick= "return confirm(\'确定要删除此附件吗?\');">删除附件</a>';
            }
        }
	    echo json_encode($out);    
    
    }
    public function viewAttachmentAction(){
        _load( "Admin_AttachmentModel");
        $attachmentInfo = Admin_AttachmentModel::readAttachmentById($_GET['id']);
        if(!$attachmentInfo){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');}
		_load( "Admin_GameModel");
		$gameInfo = Admin_GameModel::readGameById($attachmentInfo['game_id']);
		if(!$gameInfo){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');exit;}
        $navs = array(
            array('url'=>'index.php?m=cps_manage&c=cm_games','title'=>'游戏管理'),
            array('url'=>'index.php?m=cps_manage&c=cm_attachment&game_id='.$gameInfo['game_id'],'title'=>'游戏附件管理'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '查看附件');
        $this->assign('attachmentinfo',$attachmentInfo);
        $this->assign('sub_title','&nbsp;游戏ID : '.$gameInfo['game_id'].'&nbsp;游戏名称 : '.$gameInfo['game_name']);
        $this->render("/cps_manage/cm_attachment/viewAttachment.tpl","main.tpl");
    }

    public function createAttachmentAction(){
        _load( "Admin_GameModel");
		$game_info = Admin_GameModel::readGameById(@$_GET['game_id']);
		if(!$game_info){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');exit;}
		
        if(isset($_POST['file_path'])){
            if(empty($_POST['file_path']) || empty($_POST['name']) || empty($_POST['remark']) || empty($_POST['version'])){
                $this->error('信息填写不完整');
            }
            $suffix = strrchr($_POST['file_path'],'.');
            if($_POST['type'] == 'SourcePackage' && !in_array($suffix,array('.apk','.ipa'))){
                $this->error('文件类型错误');
            }
            if($_POST['type'] == 'keystore' && !in_array($suffix,array('.keystore'))){
                $this->error('文件类型错误');
            }
            $_POST['keystore_alias'] = trim($_POST['keystore_alias']);
            $_POST['keystore_pwd'] = trim($_POST['keystore_pwd']);
            if($_POST['type'] == 'keystore' && (empty($_POST['keystore_alias'])||empty($_POST['keystore_pwd'])) ){
                $this->error('信息填写不完整');
            }

            $to_dir =  rtrim(_ROOT_DIR_,'/').'/admin/Resources/game/'.$game_info['game_id'].'/attachment/';
            if(!file_exists($to_dir)){
                mkdir($to_dir,0777,true);
            }
            $suffix = strrchr($_POST['file_path'],'.');
            

            $newFileName = $_POST['name'].'_date_'.date('Y-m-dHis').$suffix;
            $res = copy($_POST['file_path'],$to_dir.$newFileName);
            if($res){
                $info['name'] = trim($_POST['name']);
                $info['remark'] = trim($_POST['remark']);
                $info['version'] = trim($_POST['version']);
                $info['type'] = trim($_POST['type']);
                $info['keystore_alias'] = trim($_POST['keystore_alias']);
                $info['keystore_pwd'] = trim($_POST['keystore_pwd']);
                $info['game_id'] = $_GET['game_id'];
                $info['path'] = 'Resources/game/'.$game_info['game_id'].'/attachment/'.$newFileName;
                $info['create_time'] = date('Y-m-d H:i:s');
                $affect_row = Doris\DDB::db()->tb_attachment()->insert($info);
                if($affect_row){
                    $this->success('操作成功','index.php?m=cps_manage&c=cm_attachment&game_id='.$_GET['game_id']);
                }else{
                    $this->error('操作失败');
                }
                exit;
            }else{
                $this->error('拷贝文件出错,请重新上传');
            }
            exit;
            
        }
        $navs = array(
            array('url'=>'index.php?m=cps_manage&c=cm_games','title'=>'游戏管理'),
            array('url'=>'index.php?m=cps_manage&c=cm_attachment&game_id='.$_GET['game_id'],'title'=>'游戏附件管理'),
        );
		$this->assign("js_para",array(
				"session_id"=>session_id(),
		));
        $this->assign('gameinfo',$game_info);
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '新建附件');
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;游戏名称 : '.$game_info['game_name']);
        #$this->display('createAttachment.tpl');
        $this->render("/cps_manage/cm_attachment/createAttachment.tpl","main.tpl");
    }
    /**
    *@Description 上传附件到临时目录
    */
    public function upload_ajaxAction(){
        set_time_limit(0);
        \Doris\DApp::loadSysLib('Upload/FileUpload.php');
	    $toDir = rtrim(_ROOT_DIR_,'/').'/admin/cache/attachment/';
        $newFileName = uniqid();
        mkdir($toDir,0777,true);
        $suffix = strrchr($_FILES['Filedata']['name'],'.');
        $fileUp = new Upload_FileUpload(array('savepath'=>$toDir, 'israndname'=>false, 'givenfilename'=>$newFileName,'allowtype'=>array('keystore','apk','ipa'),'maxsize'=>'524288000') );
        if(!$_FILES['Filedata']){
			$result = array('code'=>0,'message'=>'上传文件超过配置文件的大小');
            echo json_encode($result);exit;        
        }
		$fileUp->uploadFile('Filedata');

        if($fileUp->getErrorMsg()){
            $errorMsg = $fileUp->getErrorMsg();
			$result = array('code'=>0,'message'=>$errorMsg);
            echo json_encode($result);exit;
		}

        $result = array('code'=>1,'url'=>'cache/attachment/'.$newFileName.$suffix);
        echo json_encode($result);
    }
    
    /**
    *   修改附件
    */
    public function updateAttachmentAction(){
        _load( "Admin_AttachmentModel");
        $attachmentInfo = Admin_AttachmentModel::readAttachmentById($_GET['id']);
        if(!$attachmentInfo){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');}
        _load( "Admin_GameModel");
		$game_info = Admin_GameModel::readGameById(@$attachmentInfo['game_id']);
		if(!$game_info){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');exit;}

        if(isset($_POST['file_path'])){
            if(empty($_POST['file_path']) || empty($_POST['name']) || empty($_POST['remark'])){
                $this->error('信息填写不完整');
            }
            $suffix = strrchr($_POST['file_path'],'.');
            if($_POST['type'] == 'SourcePackage' && !in_array($suffix,array('.apk','.ipa'))){
                $this->error('文件类型错误');
            }
            if($_POST['type'] == 'keystore' && !in_array($suffix,array('.keystore'))){
                $this->error('文件类型错误');
            }
            $_POST['keystore_alias'] = trim($_POST['keystore_alias']);
            $_POST['keystore_pwd'] = trim($_POST['keystore_pwd']);
            if($_POST['type'] == 'keystore' && (empty($_POST['keystore_alias'])||empty($_POST['keystore_pwd'])) ){
                $this->error('信息填写不完整');
            }

            $tb_attachment = Doris\DDB::db()->tb_attachment[$_GET['id']];
            if($_POST['file_path'] != $attachmentInfo['path']){
                $toDir =  rtrim(_ROOT_DIR_,'/').'/admin/Resources/game/'.$game_info['game_id'].'/attachment/';
                if(!file_exists($toDir)){
                    mkdir($toDir,0777,true);
                }
                $suffix = strrchr($_POST['file_path'],'.');
                $newFileName = $_POST['name'].'_date_'.date('YmdHis').$suffix;
                $res = copy($_POST['file_path'],$toDir.$newFileName);
                if($res){
                    $tb_attachment['path'] = 'Resources/game/'.$game_info['game_id'].'/attachment/'.$newFileName;
                    @unlink(rtrim(_ROOT_DIR_,'/').'/admin/'.$attachmentInfo['path']);
                }else{
                    $this->error('拷贝文件出错,请重新上传');
                }
            }
            $tb_attachment['name'] = trim($_POST['name']);
            $tb_attachment['remark'] = trim($_POST['remark']);
            $tb_attachment['type'] = trim($_POST['type']);
            $tb_attachment['keystore_alias'] = trim($_POST['keystore_alias']);
            $tb_attachment['keystore_pwd'] = trim($_POST['keystore_pwd']);
            $tb_attachment->update();
            $this->success('操作成功');exit;
            
        }
        $navs = array(
            array('url'=>'index.php?m=cps_manage&c=cm_games','title'=>'游戏管理'),
            array('url'=>'index.php?m=cps_manage&c=cm_attachment&game_id='.$game_info['game_id'],'title'=>'游戏附件管理'),
        );
		$this->assign("js_para",array(
				"session_id"=>session_id()
		));
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '修改附件');
        $this->assign('attachmentinfo',$attachmentInfo);
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;游戏名称 : '.$game_info['game_name']);
        $this->render("/cps_manage/cm_attachment/updateAttachment.tpl","main.tpl");
    
    }

    public function delAttachmentAction(){
        _load( "Admin_AttachmentModel");
        $attachmentInfo = Admin_AttachmentModel::readAttachmentById($_GET['id']);
        if(!$attachmentInfo){$this->error('页面未找到','index.php?m=cps_manage&c=cm_games');}

        $res = Admin_AttachmentModel::delAttachmentById($_GET['id']);
        if($res){
            @unlink(rtrim(_ROOT_DIR_,'/').'/admin/'.$attachmentInfo['path']);
            $this->success('操作成功','index.php?m=cps_manage&c=cm_attachment&game_id='.$attachmentInfo['game_id']);
        }else{
            $this->error('操作失败');
        }
        exit;

    
    }

}