<?php
use Doris\DApp,
    Doris\DCache,
    Doris\DLog,
    app\source\phprpc\PHPRPC_Client,
    Doris\DConfig;
class igame_testController extends TestLib_Test {
 	private $appkey;
    private $igame_conf;

	function beforeTest(){
		#$this->KEY = "046B3F02DBC2C74D1BBF6A64CF81ECDF";

	}
	
	
	function afterTest(){

		
	}
	public function __construct(){
 
		header("Content-type: text/html; charset=utf-8");
        $this->igame_conf = DConfig::get("igame");
        $this->appkey = $this->igame_conf["keys"]['appkey'];
        $this->setHost($this->igame_conf['host']."/");

        $this->setTitle("igame 测试");
        $this->setRecvInfoOnREST("msg_code","msg_result","data");
        
        #$this->afterTest();
        $this->beforeTest();
        
		$this->beginTest();
	}
	
	public function __destruct(){
		 $this->endTest();
		 if( !isset($_GET['k']) )
       	 	$this->afterTest();
         parent :: __destruct();
	}
	
	//MARK:- 一些辅助函数
	private function _getSign( $data){
        ksort($data);
        $pair = array();
        foreach($data as $k => $v){
            if($v==''){
                continue;
            }
            $pair[] = $k.'='.$v;
        }
        $str = implode('#', $pair);
		//echo $str.$this->appkey;exit;
        $sign = md5($str.$this->appkey);
        return $sign;
	}
	private function commonSignData($exData = [],$notSignData=[]){
        $data = $exData ;
        $data["sign"] = $this->_getSign($data);
        //之后字段不参与签名
        $data = array_merge($data, $notSignData);
        return $data;
	}
	
	//===============================================
	
	//index
	public function test(){
		
        $this->displayDetailFailed();
        if( isset($_GET['d']) )$this->displayDetail();
        if( isset($_GET['s']) )$this->displaySimple();
        
        $this->resetIndex();
        
        //开始测试

		
		$this->addSeparator("用户相关测试");//输出换行分隔符

		$this->gameListAction();
		$this->shopListAction();
		$this->userRoleAction();

		//$this->orderListAction();
		//$this->updiscountAction();
	}
	
	/*
	*	http://icenter.netkingol.com/iuserplat_test?d&k
	*/
	public function indexAction(){ 
		$this->test(); 	
	}

	//1游戏列表
	public function gameListAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => '321137',
								'pid' => 145,
								'projectname'=>'guild_webpay',
						] ,[

						]),

						"游戏 列表",
						[
								"0+appid+"=> ["==", "321137"] ,
						],
						"rpc",
						"getArea"
				);

		$this->endSubTest();
	}


	//2游戏商品列表
	public function shopListAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => '321137',
								'projectname'=>'guild_webpay',
						] ,[

						]),

						"游戏商品 列表",
						[
								"0+goodsid+"=> ["==", "SBK04"] ,
						],
						"rpc",
						"getProduct"
				);

		$this->endSubTest();
	}


	//3用户角色列表
	public function userRoleAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => '321137',
								'role_id' => '14',
								'server_id' => '9011',
								'server_name' => '安卓测试',
								'projectname'=>'guild_webpay',
						] ,[

						]),

						"用户角色 列表",
						[
								"result+"=> ["==", "0"] ,
						],
						"rpc",
						"checkUserByRoleid"
				);
		$this->endSubTest();
	}

	//3下订单
	public function orderAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => '321137',
								'ktuid' => '123',
								'account_id' => '123',
								'role_id' => '123',
								'role_name' => '123',
								'area_id' => '123',
								'area_name' => '123',
								'role_level' => '123',
								'product_id' => 'SBK04',
								'server_id' => '145',
								'server_name' => '创世二区',
								'discount' => '0.5',
								'userip' => '10.25.38.49',
								'projectname'=>'guild_webpay',
						] ,[

						]),

						"用户角色 列表",
						[],
						"rpc",
						"getOrder"
				);

		$this->endSubTest();
	}

	//5通知发货接口
	public function notifyAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => '9011',
								'server_id' => '',
								'server_name' => '',
								'projectname'=>'guild_webpay',
						] ,[

						]),

						"游戏商品 列表",
						[],
						"rpc",
						"getOrder"
				);

		$this->endSubTest();
	}
	
}