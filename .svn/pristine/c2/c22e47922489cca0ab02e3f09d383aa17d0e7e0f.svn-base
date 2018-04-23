<?php 
class loginController extends commonController{
	
	public function __construct(){
		if(_ACTION_!="index")
			parent::__construct();
	}
	
	public function indexAction(){
	//echo $this->getView()->getScriptPath();exit;
		if(isset($_POST['submit'])){
			if($_POST['agreement'] != 1)$this->error('请同意代理协议');
			if($_POST['ycode'] != $_SESSION['ycode'])$this->error('验证码有误');
			$username=$_POST['name'];
			$password=$_POST['secret'];

			if(empty($password) || empty($username))$this->error('用户名或密码不能为空');
			$adminModel = Doris\DApp::newClass( "Mobile_AdminModel");
			$userInfo = $adminModel->checkUserNamePwd($username,md5($password));
			if(!$userInfo){
				$this->error('用户名或者密码错误！');
				return;
			}else{
				if ($userInfo['state'] == 0) {
					$this->error('帐号已经停用！');
				}
				if(empty($userInfo['extend'])){
					//详细图标参见：http://wiki.qiaochenglei.cn/resources/ace1.3.3/html/buttons.html
					$extend= <<<EOF
{
  "shortcuts":[
   { "url":"?m=index",  "icon":"fa fa-tachometer", "btnClass":"btn-info"},
   { "url":"?m=index&c=home&a=modify", "icon":"glyphicon glyphicon-user","btnClass":"btn-success"}
  ]
}
EOF;
					$userInfo['extend']=$extend;
					
				}
				$this->sessionUserInfo($userInfo);
			 
				$this->back_or('index.php');
			}
		}else{
			$_SESSION['ycode'] = rand(1000,9999);
			$this->render(
				[	
					"dorisContent"=>"login.tpl",
					"currentPageJsContent"=>"login.js.tpl"
				],
				"main.basic.tpl");
		}
		return false;
		
	}
	public function logoutAction(){
		 $this->clear_login();
		 $this->redirect('?');
	}

	/**
	 * @Description 修改密码
	 * @return void|boolean
	 * 
	 */
	
	public function change_passAction(){
		$this->ensureAdmin($this->cur_url());
        $adminModel = Doris\DApp::newClass("Admin_AdminModel")  ;
		if(!empty($_POST['info'])){
			$info=$_POST['info'];
			//检测用户填写信息
			if(empty($info['oldpassword']))$this->error('原密码不能为空！');
			if($info['password']!=$info['repass'])$this->error('两次密码不一致'); 
			$userinfo = $adminModel->readAdminById($_SESSION['admin']['id']);  //取用户信息
			if($userinfo['user_pwd'] != md5($info['oldpassword'])){
				$this->error('原密码错误！');
				return false;
			}
			//修改密码
	        $updateSucc = $adminModel->updatePwd(md5($info['password']),$_SESSION['admin']['id']);
			if(!$updateSucc){
				$this->error('Error！');
				return;
			}else{
                $this->refreshSession();
				$this->success('Success！','?');
			}
		}else{
			$this->render('admin_change_pass.tpl');
		}
			
	}//END change_pass
	
}