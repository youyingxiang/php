<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
Doris\DConfig,
DataTables\Editor\Validate;



/**
 * @Description 管理
 * 
 */

Doris\DApp::loadController("common","cps_common");

class cm_unionlistController extends cps_commonController{
    public function __construct(){
        if(_ACTION_!="notify")
            parent::__construct();
    }

	public function indexAction(){

		$this->assign("second_menu", "secon_menu.tpl");
		$this->assign("js", "cps_manage/cm_unionlist_list.js"); 
		
		$this->assign("title", _lan('BackgroundUserManagement','渠道列表'));
		
		$this->assign("js_privilege", json_encode(array("privilege_code"=>5 )));
        $this->assign('js_para',json_encode(array('game_id'=>@$_GET['game_id'])));
		$this->render(false,"common_list.tpl");
	}
	
	public function index_ajaxAction(){
		$db = Doris\DApp::loadDT();
 		$editor = Editor::inst( $db, 'tb_unionlist', 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' )->validator( 'Validate::notEmpty' ),
				Field::inst( 'state' ),
				Field::inst( 'plattype' ),
				Field::inst( 'open_flag' ),
				Field::inst( 'package_state' ),
				Field::inst( 'package_url' ),
				Field::inst( 'cdn_url' ),
				Field::inst( 'tmp_package_version' ),
				Field::inst( 'cdn_package_version' ),
				Field::inst( 'product_id' )
					->options( 'tb_games', 'game_id', 'game_name' ) 
					->validator( 'Validate::notEmpty' ),
                Field::inst( 'code' )
                    ->validator( 'Validate::notEmpty' )
			);
        $res = $this->getChildrenAndMyIds($_SESSION['admin']['id']);
        $agent_unions = $this->getAgentsUnions($res);
        $editor->where(function($q) use($agent_unions ) {
            $union_ids = array_keys( $agent_unions );
            $union_ids = implode(",", $union_ids );
            if(!empty($union_ids) ){
                $q->where('id', "( $union_ids) ", 'IN', false);
            }
        });
		if( !empty($_GET['game_id']) ){
			$editor->where("product_id",$_GET['game_id']);
		}
        if(@$_POST['action'] == 'edit'){
           # print_r($_POST);exit;
            //同步到 iuser
            $data = $_POST['data'];
            $data = array_shift($data);
            $iuser = _new("Service_IUser");
            $r = $iuser->unionUpdate($data['id'],$data['name'],$data['plattype'],$data['open_flag'],$_SESSION['admin']['user_name']);
            if(@$r[1] != 20000){
                $msg = json_decode($r[4],true);
                $msg = $msg['msg_content']?$msg['msg_content']:"数据同步出错";
                echo '{"error":"'.$msg.'","data":[]}';exit;
            }
        }
        if(@$_POST['action'] == 'create'){
            //同步到 iuser
            $data = $_POST['data'][0];
            $iuser = _new("Service_IUser");
            $r = $iuser->unionAdd($data['name'],$data['product_id'],$data['code'],$data['plattype'],$data['open_flag'],0,$_SESSION['admin']['user_name']);
            if(@$r[1] != 20000){
                $msg = json_decode($r[4],true);
                $msg = $msg['msg_content']?$msg['msg_content']:"数据同步出错";
                echo '{"error":"'.$msg.'","data":[]}';exit;
            }
            $_POST['data'][0]['id'] = $r[3]['channel_id'];
            // 渠道关联 （ IGNORE 自动排重 ）
            $sql = "INSERT IGNORE INTO `tb_sys_user_union` ( `user_id`, `union_id` ) values ({$_SESSION['admin']['id']},{$r[3]['channel_id']})";
            Doris\DDB::execute($sql );
        }

        $data = $editor->process( $_POST )->data();

        foreach($data['data'] as $k=>$v){
            $data['data'][$k]['operation'] = "<a href='/index.php?m=cps_manage&c=cm_childunionlist&parent_id={$data['data'][$k]['id']}'>子渠道管理</a>";
            $data['data'][$k]['operation'] .= "<br /><a href='/index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id={$data['data'][$k]['id']}' target='_blank'>生成渠道包</a>";
            if($v['state'] == 1){
                $data['data'][$k]['state_note'] = "未生成渠道包";
            }elseif($v['state'] == 2){
                $data['data'][$k]['state_note'] = "已生成渠道包";
                $data['data'][$k]['operation'] .= "<br /><a href='/index.php?m=cps_manage&c=cm_unionlist&a=pushCdn&id={$data['data'][$k]['id']}'>推送CDN</a>";
            }elseif($v['state'] == 3){
                $data['data'][$k]['state_note'] = "已推送到CDN";
                $data['data'][$k]['operation'] .= "<br /><a href='/index.php?m=cps_manage&c=cm_unionlist&a=refreshCdn&id={$data['data'][$k]['id']}' onclick=\"{if(confirm('确定要刷新CDN缓存吗?')){return true;}return false;}\">刷新CDN缓存</a>";
                $data['data'][$k]['operation'] .= "<br /><a href='/index.php?m=cps_manage&c=cm_unionlist&a=warmCdn&id={$data['data'][$k]['id']}' onclick=\"{if(confirm('确定要预热CDN吗?')){return true;}return false;}\">CDN预热</a>";
            }
            $data['data'][$k]['package_state_note'] = '';
            if($v['package_state'] == 0){
                $data['data'][$k]['package_state_note'] = "未打包";
            }elseif($v['package_state'] == 1){
                $data['data'][$k]['package_state_note'] = "<font color='f0ad4e'>等待打包</a>";
            }elseif($v['package_state'] == 3){
                $data['data'][$k]['package_state_note'] = "<font color='green'>打包成功</font>";
            }elseif($v['package_state'] == 4){
                $data['data'][$k]['package_state_note'] = "<font color='red'>打包失败</font>";
            }

            $data['data'][$k]['package_url'] = $v['package_url']?'<div style="max-width:300px">'.$v['package_url'].'<br />包版本:<font color="#f0ad4e">'.$v['tmp_package_version'].'</font></div>':'';
            $data['data'][$k]['cdn_url'] = $v['cdn_url']?'<div style="max-width:300px">'.$v['cdn_url'].'<br />包版本:<font color="#f0ad4e">'.$v['cdn_package_version'].'</font></div>':'';
        }




        echo json_encode($data);
		//$editor->process( $_POST ) ->json();
		
	}

  
 
	public function fetchUnionlistAction(){
        echo 1;exit;
	 	$cur_user_id = $this->getCurrentUser()['id'];
	 	
       	$user_name = $_GET['user_name'];
       	$password = $_GET['user_pass'];
		$since_id = -10 ;
		$game_id = $_GET['game_id']; 
		$fields = 'id, name, sortid, classid, action, adurl, adurl_ios, adurl_and, deduct_ratio, product_id, config_id';
		 
        
		$icenter = _new("Service_ICenter");   
		$page = 0;
		$page_size = 50; 
		
		$r = false;
		$cleared = false;
		do{
			
		 	$r = $icenter->unionListGet($user_name, $password , $since_id ,$game_id ,$page , $page_size   ) ;
		
			if($r[1] == 0){//成功 
				$values ='';
				$values_uu ='';
				$fields_arr = explode("," , $fields );
				$datas = $r[3]['root']; 
				foreach($datas  as $idx => &$data){
					if( $idx > 0 ){
						$values .= "," ;
						$values_uu .= "," ;
					}
					
					// for `tb_unionlist`
					$values .= "(" ; 
					array_walk($fields_arr ,function ($v,$k) use(&$values,&$data ) { 
						if($k > 0)  $values .= "," ;
						 $values .= "'".$data[trim($v)] ."'" ;
					});
					$values .= ")" ;
					
					// for `tb_sys_user_union`
					$values_uu .= "( $cur_user_id , '".$data['id'] ."' )" ;
				}
				
				if(!empty($values)){
// 					//第一页请求完成时先清一下数据
// 					if( ! $cleared ){
// 						$sql = "delete from  tb_unionlist where product_id = '$game_id' ";
// 						$data = Doris\DDB::execute($sql );
// 						$cleared = true;
// 					}
					
					$sql = "INSERT IGNORE INTO tb_unionlist ($fields ) values ".$values; 
					$result = Doris\DDB::execute($sql );
					// Doris\debugWeb($sql,false);
					
					
					// 渠道关联 （ IGNORE 自动排重 ）
					$sql_uu = "INSERT IGNORE INTO `tb_sys_user_union` ( `user_id`, `union_id` ) values ".$values_uu;
					$result = Doris\DDB::execute($sql_uu );
					
				}
			
			}else{ 
				echo json_encode(['code'=>$r[1],"msg"=>$r[2] ]);exit;
			}
			sleep(1); // 休息一下，不要频繁拉大数据
			$page ++;
		}while( !empty($r[3]['root']) && count($r[3]['root']) ==  $page_size );
		
		
		echo json_encode(['code'=>'0',"msg"=>"成功" ]);
	}


    public function uploadPackageFile_ajaxAction(){
        _load( "Admin_AttachmentModel");
        $package_id = @$_POST['package_id']+0;
        #$package_id = $_GET['package_id'];
        //获取母包
        $source_package = Admin_AttachmentModel::readAttachmentById($package_id);
        if(!$source_package) {
            echo json_encode(array('state'=>2,'msg'=>'母程序包不存在'));exit;
        }
        $package_file_path = $source_package['path'];
        $ipackage = _new("Service_IPackage");
        $package_file = rtrim(rtrim(_ROOT_DIR_,'/'),'\\').'/admin/'.$package_file_path;
        $res = $ipackage->uploadPackageFile($package_file);
        if($res[1] !== 0){  //失败
            echo json_encode(array('state'=>2,'msg'=>$res[2]));exit;
        }
        echo json_encode(array('state'=>0,'data'=>$res[3]['root']['file_id']));

    }
    //生成渠道包
    public function createPackageAction(){
        //渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_GET['id']);
        if(!$union_info){$this->error('渠道未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}

        if($_POST){ //打包
            $package_id = $_POST['package_id']+0;
            $keystore_id = @$_POST['keystore_id']+0;
            $package_name = trim($_POST['package_name']);
            if(empty($package_id)){
                $this->error('参数不全','index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);exit;
            }
            //获取母包
            $source_package = Admin_AttachmentModel::readAttachmentById($package_id);
            if(!$source_package){$this->error('母程序包不存在','index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);exit;}
            if(strtolower(strrchr($source_package['path'],'.')) == '.apk'){ //安卓
                if(empty($keystore_id) || empty($package_name)){
                    $this->error('参数不全','index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);exit;
                }
                //获取证书
                $keystore_file = Admin_AttachmentModel::readAttachmentById($keystore_id);
                if(!$keystore_file){$this->error('证书不存在','index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);exit;}
                $keystore_file_path = $keystore_file['path'];
                $keystore_alias = $keystore_file['keystore_alias'];
                $keystore_pwd = $keystore_file['keystore_pwd'];
            }

            //开始打包
            $product_id = $union_info['product_id'];//product_id
            $union_id = $union_info['id']; //父id
            $union_code = $union_info['code'];//父标识
            $game_version = $source_package['version'];//游戏version，由母包版本来定
            $child_union_id = 0; //子id
            $child_union_code = ''; //子标识
            $package_file_path = $source_package['path'];
            $notify_url = urlencode("http://{$_SERVER['HTTP_HOST']}/index.php?m=cps_manage&c=cm_unionlist&a=notify");
            $res = $this->doCreatePackage($product_id,$union_id,$child_union_id,$union_code,$child_union_code,$package_name,$game_version,$package_file_path,@$keystore_file_path,@$keystore_alias,@$keystore_pwd,$notify_url);
            if($res['state'] !== 0){
                $this->error($res['msg'],'/index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);
            }
            $updateArgs = array("package_state"=>1);
            Admin_UnionlistModel::updateById($updateArgs,$_GET['id']);
            $this->success('操作成功','index.php?m=cps_manage&c=cm_unionlist');
            exit;

            
        }
        
        //获取证书及母包列表
        $soucePackageList = Admin_AttachmentModel::readAttachmentList($union_info['product_id'],"SourcePackage");
        if(!$soucePackageList){
            $this->error('母程序包不存在','index.php?m=cps_manage&c=cm_unionlist&a=createPackage&id='.$_GET['id']);exit;
        }
        foreach($soucePackageList as $k=>$v){
            $soucePackageList[$k]['is_android'] = strtolower(strrchr($v['path'],'.')) == '.apk'?1:0;
        }
        $keystoreList = Admin_AttachmentModel::readAttachmentList($union_info['product_id'],"keystore");
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$union_info['product_id']);

        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist','title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '生成渠道包');
        $this->assign('soucePackageList',$soucePackageList);
        $this->assign('keystoreList',$keystoreList);
        $this->assign('union_info',$union_info);
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        $this->assign('title','生成渠道包');
        $this->render("/cps_manage/cm_unionlist/createPackage.tpl","main.tpl");    

    }

    //批量生成渠道包
    public function batchCreatePackageAction(){
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$_GET['product_id']);
        if(!$game_info){$this->error('游戏未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}

        //获取渠道列表
        $list = Admin_UnionlistModel::readList($_GET['product_id']);
        if(!$list){
            $this->error('此游戏没有渠道数据','/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id']);exit;
        }
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$_GET['product_id']);
        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id'],'title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '批量生成渠道包');
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        if(isset($_POST['submitSelectCode'])){
            if(empty($_POST['union_id'])){
                $this->error('请至少选择一个渠道包');
            }
            //获取证书及母包列表
            $soucePackageList = Admin_AttachmentModel::readAttachmentList($_GET['product_id'],"SourcePackage");
            if(!$soucePackageList){
                $this->error('母程序包不存在');
            }
            foreach($soucePackageList as $k=>$v){
                $soucePackageList[$k]['is_android'] = strtolower(strrchr($v['path'],'.')) == '.apk'?1:0;
            }
            $keystoreList = Admin_AttachmentModel::readAttachmentList($_GET['product_id'],"keystore");
            $union_ids = implode(',',$_POST['union_id']);
            $channels = Admin_UnionlistModel::readListInIds($union_ids);
            $this->assign('soucePackageList',$soucePackageList);
            $this->assign('keystoreList',$keystoreList);
            $this->assign('unionList',$channels);
            $this->render("/cps_manage/cm_unionlist/batchCreatePackage_step2.tpl","main.tpl");  
            exit;
        }

        $this->assign('unionList',$list);
        $this->render("/cps_manage/cm_unionlist/batchCreatePackage.tpl","main.tpl");  

    }

    //批量生成渠道包 ajax
    public function batchCreatePackage_ajaxAction(){
//         _load( "Admin_UnionlistModel");
//         _load( "Admin_AttachmentModel");
//         _load( "Admin_GameModel");

        $package_id = $_POST['package_id']+0;
        $package_file_id = $_POST['package_file_id']+0;
        $keystore_id = @$_POST['keystore_id']+0;
        $package_name = trim(@$_POST['package_name']);
        $union_id = $_POST['union_id']+0;
        if(empty($package_id) || empty($union_id) || empty($package_file_id)  ){
            echo json_encode(array("state"=>1,"msg"=>"参数不全"));exit;
        }
        $union_info = Admin_UnionlistModel::readUnionInfoById($union_id);
        if(!$union_info){echo json_encode(array("state"=>1,"msg"=>"渠道未找到"));exit;}
        //获取母包
        $source_package = Admin_AttachmentModel::readAttachmentById($package_id);
        if(!$source_package){ echo json_encode(array("state"=>1,"msg"=>"母程序包不存在"));exit;}
        
        if(strtolower(strrchr($source_package['path'],'.')) == '.apk'){ //安卓
            if(empty($keystore_id) || empty($package_name)){
                echo json_encode(array("state"=>1,"msg"=>"参数不全"));exit;
            }
            //获取证书
            $keystore_file = Admin_AttachmentModel::readAttachmentById($keystore_id);
            if(!$keystore_file){echo json_encode(array("state"=>1,"msg"=>"证书不存在"));exit;}
            $keystore_file_path = $keystore_file['path'];
            $keystore_alias = $keystore_file['keystore_alias'];
            $keystore_pwd = $keystore_file['keystore_pwd'];
        }
        //开始打包
        $product_id = $union_info['product_id'];//product_id
        $union_id = $union_info['id'];
        $union_code = $union_info['code'];
        $game_version = $source_package['version'];//游戏version，由母包版本来定
        $child_union_id = 0; //子id
        $child_union_code = '';
        #$package_file_path = $source_package['path'];
        $notify_url = urlencode("http://{$_SERVER['HTTP_HOST']}/index.php?m=cps_manage&c=cm_unionlist&a=notify");
        $res = $this->doCreatePackage($product_id,$union_id,$child_union_id,$union_code,$child_union_code,@$package_name,$game_version,'',@$keystore_file_path,@$keystore_alias,@$keystore_pwd,$notify_url,$package_file_id);
        if($res['state'] !== 0){
            echo json_encode(array("state"=>1,"msg"=>$res['msg']));exit;
        }
        $updateArgs = array("package_state"=>1);
        Admin_UnionlistModel::updateById($updateArgs,$union_id);
        echo json_encode(array("state"=>0,"msg"=>'success'));
        exit;


    }

    private function doCreatePackage($product_id,$union_id,$child_union_id,$union_code,$child_union_code,$package_name,$game_version,$package_file,$keystore_file,$keystore_alias,$keystore_pwd,$notify_url,$package_file_id = 0){
        $ipackage = _new("Service_IPackage");
        if($package_file){
            $package_file = rtrim(rtrim(_ROOT_DIR_,'/'),'\\').'/admin/'.$package_file;
        }
        if($keystore_file){
            $keystore_file = rtrim(rtrim(_ROOT_DIR_,'/'),'\\').'/admin/'.$keystore_file;
        }
        $res = $ipackage->createPackage($product_id,$union_id,$child_union_id,$union_code,$child_union_code,$package_name,$game_version,$package_file,$keystore_file,$keystore_alias,$keystore_pwd,$notify_url,$package_file_id);
        if($res[1] !== 0){  //失败
            return array('state'=>1,'msg'=>$res[2]);
        }

        return array('state'=>0,'msg'=>'success');
    }

    //推到cdn
    public function pushCdnAction(){
        _load( "Admin_UnionlistModel");
        _load( "Admin_AttachmentModel");
        _load( "Admin_GameModel");
        //渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_GET['id']);
        if(!$union_info){$this->error('渠道未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}
        if($union_info['state'] != 2){
            $this->error('请先生成渠道包','/index.php?m=cps_manage&c=cm_childunionlist&parent_id='.$union_info['parent_id']);exit;
        }
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$union_info['product_id']);

        if($_POST){
            $res = $this->doPushCDN($union_info['product_id'],$union_info['id'],0,$union_info['tmp_package_version']);
            if($res['state'] !== 0){
                $this->error($res['msg'],'/index.php?m=cps_manage&c=cm_unionlist&a=pushCdn&id='.$union_info['id']);
            }
            if(!$res['cdn_url']){
                $this->error("推送cdn失败,返回参数缺少cdn_url",'/index.php?m=cps_manage&c=cm_unionlist&a=pushCdn&id='.$union_info['id']);

            }
            $updateArgs = array();
            $updateArgs['state'] = 3;
            $updateArgs['cdn_url'] = urldecode($res['cdn_url']);
            $updateArgs['cdn_package_version'] = $union_info['tmp_package_version'];
            Admin_UnionlistModel::updateById($updateArgs,$union_info['id']);

            $this->success('推送CDN成功','/index.php?m=cps_manage&c=cm_unionlist');exit;
        }


        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist','title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign('union_info',$union_info);
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        $this->assign('title','推送CDN');
        $this->render("/cps_manage/cm_unionlist/pushCdn.tpl","main.tpl");   

    }

    //批量推送cdn
    public function batchPushCDNAction(){
        _load( "Admin_UnionlistModel");
        _load( "Admin_GameModel");
		$game_info = Admin_GameModel::readGameById(@$_GET['product_id']);
        if(!$game_info){$this->error('游戏信息未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}

        //获取子渠道列表
        $list = Admin_UnionlistModel::readList($_GET['product_id'],2);
        if(!$list){
            $this->error('没有需要推送CDN的渠道数据','/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id']);exit;
        }

        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$parent_union_info['product_id']);

        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id'],'title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '批量推送CDN');
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        if(isset($_POST['submitSelectCode'])){
            if(empty($_POST['union_id'])){
                $this->error('请至少选择一个渠道包');
            }
            $union_ids = implode(',',$_POST['union_id']);
            $channels = Admin_UnionlistModel::readListInIds($union_ids);
            $this->assign('unionList',$channels);
            $this->render("/cps_manage/cm_unionlist/batchPushCDNAction_step2.tpl","main.tpl");  
            exit;
        }

        $this->assign('unionList',$list);
        $this->render("/cps_manage/cm_unionlist/batchPushCDN.tpl","main.tpl");  
    }

    //批量推送CDN ajax
    public function batchPushCDN_ajaxAction(){
        _load( "Admin_UnionlistModel");
        _load( "Admin_AttachmentModel");
        _load( "Admin_GameModel");

        $union_id = $_POST['union_id']+0;
        if(empty($union_id) ){
            echo json_encode(array("state"=>1,"msg"=>"参数不全"));exit;
        }
        $union_info = Admin_UnionlistModel::readUnionInfoById($union_id);
        if(!$union_info || $union_info['state'] != 2){echo json_encode(array("state"=>1,"msg"=>"渠道未找到或渠道包状态错误"));exit;}
        //开始推送
        $res = $this->doPushCDN($union_info['product_id'],$union_info['id'],0,$union_info['tmp_package_version']);
        if($res['state'] !== 0){
             echo json_encode(array("state"=>1,"msg"=>$res['msg']));exit;
        }
        if(!$res['cdn_url']){
             echo json_encode(array("state"=>1,"msg"=>'缺少CDN url参数'));exit;

        }
        $updateArgs = array();
        $updateArgs['state'] = 3;
        $updateArgs['cdn_url'] = urldecode($res['cdn_url']);
        $updateArgs['cdn_package_version'] = $union_info['tmp_package_version'];
        Admin_UnionlistModel::updateById($updateArgs,$union_info['id']);
        echo json_encode(array("state"=>0,"msg"=>'success'));
        exit;


    }



    //打包系统通知打包结果接口
    public function notifyAction(){
        _load( "Admin_UnionlistModel");
        $union_id = @$_GET['union_id']+0;
        $state = @$_GET['state']+0;
        $package_url = @$_GET['package_url'];
        $version = @$_GET['version'];
        if(!$union_id){
            echo json_encode(array("state"=>0,"msg"=>"缺少参数"));exit;
        }
        $union_info = Admin_UnionlistModel::readUnionInfoById($union_id);
        if(!$union_info){
            echo json_encode(array("state"=>0,"msg"=>"渠道信息未找到"));exit;
        }
        $updateArg= array();
        if($state == 1){ //成功
            $package_url = urldecode($package_url);
            if(!$package_url || !$version){echo json_encode(array("state"=>0,"msg"=>"缺少参数"));exit;}
            $conf = DConfig::get("ipackage");
            if(stripos($package_url,"http") === false){
                $package_url = $conf['host'].'/'.$package_url;
            }
            $updateArg['package_state'] = 3;
            $updateArg['state'] = 2;
            $updateArg['tmp_package_version'] = $version;
            $updateArg['package_url'] = $package_url;
        }else{
            $updateArg['package_state'] = 4;
        }
        Admin_UnionlistModel::updateById($updateArg,$union_id);
        echo json_encode(array("state"=>1,"msg"=>"success"));exit;


    }

    /**
    *   推送到cdn
    */
    private function doPushCDN($product_id,$union_id,$child_union_id,$game_version){
        $ipackage = _new("Service_IPackage");
        $res = $ipackage->pushCDN($product_id,$union_id,$child_union_id,$game_version);
        if($res[1] !== 0){  //失败
            return array('state'=>1,'msg'=>$res[2]);
        }
        return array('state'=>0,'msg'=>'success',"cdn_url"=>$res[3]['root']['cdn_url']);
    }


    //刷新cdn缓存
    public function refreshCdnAction(){
        _load( "Admin_UnionlistModel");
        //渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_GET['id']);
        if(!$union_info){$this->error('渠道未找到','/index.php?m=cps_manage&c=cm_unionlist');exit;}
        if($union_info['state'] != 3){
            $this->error('渠道包状态错误','/index.php?m=cps_manage&c=cm_unionlist');exit;
        }
        $res = $this->doRefreshCDN($union_info['cdn_url']);

        if($res['state'] !== 0){
            $this->error($res['msg'],'/index.php?m=cps_manage&c=cm_unionlist');
        }
        $this->success('刷新CDN缓存成功','/index.php?m=cps_manage&c=cm_unionlist');exit;

    }

    //批量刷新cdn缓存
    public function batchRefreshCDNAction(){
        _load( "Admin_UnionlistModel");
        _load( "Admin_GameModel");
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$_GET['product_id']);
        if(!$game_info){$this->error('游戏未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}

        //获取子渠道列表
        $list = Admin_UnionlistModel::readList($_GET['product_id'],3);
        if(!$list){
            $this->error('没有可以刷新CDN缓存的渠道数据','/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id']);exit;
        }


        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id'],'title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '批量刷新CDN缓存');
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        if(isset($_POST['submitSelectCode'])){
            if(empty($_POST['union_id'])){
                $this->error('请至少选择一个渠道包');
            }
            $union_ids = implode(',',$_POST['union_id']);
            $channels = Admin_UnionlistModel::readListInIds($union_ids);
            $this->assign('unionList',$channels);
            $this->render("/cps_manage/cm_unionlist/batchRefreshCDN_step2.tpl","main.tpl");  
            exit;
        }

        $this->assign('unionList',$list);
        $this->render("/cps_manage/cm_unionlist/batchRefreshCDN.tpl","main.tpl");  
    }

    //批量刷新cdn缓存
    public function batchRefreshCDN_ajaxAction(){
        _load( "Admin_UnionlistModel");
        //子渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_POST['union_id']);
        if(!$union_info || $union_info['state'] != 3){echo json_encode(array("state"=>1,"msg"=>"渠道未找到或渠道包状态错误"));exit;}
        
        $res = $this->doRefreshCDN($union_info['cdn_url']);

        if($res['state'] !== 0){
            echo json_encode(array("state"=>1,"msg"=>$res['msg']));exit;
        }
        //$updateArgs = array();
        //$updateArgs['state'] = 3;
        //Admin_ChildUnionlistModel::updateById($updateArgs,$union_info['id']);

        echo json_encode(array("state"=>0,"msg"=>'success'));exit;

    }

 


    //预热cdn缓存
    public function warmCdnAction(){
        _load( "Admin_UnionlistModel");
        //渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_GET['id']);
        if(!$union_info){$this->error('渠道未找到','/index.php?m=cps_manage&c=cm_unionlist');exit;}
        if($union_info['state'] != 3){
            $this->error('渠道包状态错误','/index.php?m=cps_manage&c=cm_unionlist');exit;
        }
        $union_info['cdn_url'] = "http://cdn.netkingol.com/channel_bin2/520002/apk/1.0.0/520002_10108.apk";
        $res = $this->doWarmCDN($union_info['cdn_url']);

        if($res['state'] !== 0){
            $this->error($res['msg'],'/index.php?m=cps_manage&c=cm_unionlist');
        }

        $this->success('预热CDN缓存成功','/index.php?m=cps_manage&c=cm_unionlist');exit;

    }

    //批量刷新cdn缓存
    public function batchWarmCDNAction(){
        _load( "Admin_UnionlistModel");
        _load( "Admin_GameModel");
        //游戏信息
		$game_info = Admin_GameModel::readGameById(@$_GET['product_id']);
        if(!$game_info){$this->error('游戏未找到','index.php?m=cps_manage&c=cm_unionlist');exit;}

        //获取渠道列表
        $list = Admin_UnionlistModel::readList($_GET['product_id'],3);
        if(!$list){
            $this->error('没有可以预热CDN缓存的渠道数据','/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id']);exit;
        }

        $navs = array(
            array('url'=>'/index.php?m=cps_manage&c=cm_unionlist&game_id='.$_GET['product_id'],'title'=>'渠道列表'),
        );
        $this->assign("menu", "game/menu.tpl");
        $this->assign('navs',$navs);
        $this->assign('navs_tpl','/navs.tpl');
        $this->assign("title", '批量预热CDN');
        $this->assign('sub_title','&nbsp;游戏ID : '.$game_info['game_id'].'&nbsp;&nbsp;游戏名称 : '.$game_info['game_name']);
        if(isset($_POST['submitSelectCode'])){
            if(empty($_POST['union_id'])){
                $this->error('请至少选择一个渠道包');
            }
            $union_ids = implode(',',$_POST['union_id']);
            $channels = Admin_UnionlistModel::readListInIds($union_ids);
            $this->assign('unionList',$channels);
            $this->render("/cps_manage/cm_unionlist/batchWarmCDN_step2.tpl","main.tpl");  
            exit;
        }

        $this->assign('unionList',$list);
        $this->render("/cps_manage/cm_unionlist/batchWarmCDN.tpl","main.tpl");  
    }

    //批量刷新cdn缓存
    public function batchWarmCDN_ajaxAction(){
        _load( "Admin_UnionlistModel");
        //渠道信息
        $union_info = Admin_UnionlistModel::readUnionInfoById(@$_POST['union_id']);
        if(!$union_info || $union_info['state'] != 3){echo json_encode(array("state"=>1,"msg"=>"渠道未找到或渠道包状态错误"));exit;}
        
        $res = $this->doWarmCDN($union_info['cdn_url']);

        if($res['state'] !== 0){
            echo json_encode(array("state"=>1,"msg"=>$res['msg']));exit;
        }
        //$updateArgs = array();
        //$updateArgs['state'] = 3;
        //Admin_ChildUnionlistModel::updateById($updateArgs,$union_info['id']);

        echo json_encode(array("state"=>0,"msg"=>'success'));exit;

    }


    /**
     *   刷新cdn缓存
     */
    private function doRefreshCDN($cdn_url){
        $ipackage = _new("Service_IPackage");
        $res = $ipackage->refreshCDN($cdn_url);
        if($res[1] !== 0){  //失败
            return array('state'=>1,'msg'=>$res[2]);
        }
        return array('state'=>0,'msg'=>'success');
    }
	
    /**
     *   预热cdn缓存
     */
    private function doWarmCDN($cdn_url){
        $ipackage = _new("Service_IPackage");
        $res = $ipackage->WarmCDN($cdn_url);
        if($res[1] !== 0){  //失败
            return array('state'=>1,'msg'=>$res[2]);
        }
        return array('state'=>0,'msg'=>'success');
    }
	
 
	
}