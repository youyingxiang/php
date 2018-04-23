<?php
use Doris\DApp,
    Doris\DCache,
    Doris\DLog,
    app\source\phprpc\PHPRPC_Client,
    Doris\DConfig;


class iuser_testController extends TestLib_Test {
 	private $KEY;
    private $iuser_conf;

	function beforeTest(){
		#$this->KEY = "046B3F02DBC2C74D1BBF6A64CF81ECDF";

	}
	
	
	function afterTest(){

		
	}
	public function __construct(){
 
		header("Content-type: text/html; charset=utf-8");
        $this->iuser_conf = DConfig::get("iuser");
        $this->KEY = $this->iuser_conf["keys"]['guild'];
        $this->setHost($this->iuser_conf['host']."/");

        $this->setTitle("iuser 测试");
        $this->setRecvInfoOnREST("msg_code","msg_result","data");
        
        #$this->afterTest();
        $this->beforeTest();
        
		$this->beginTest();
	}
	
	public function __destruct(){

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
        $sign = md5($str.$this->KEY);
        return $sign;
	}
	private function commonSignData($exData = [],$notSignData=[]){
        $data = $exData ;
        $data["sign"] = $this->_getSign($data);
        //之后字段不参与签名
        $data = array_merge($data, $notSignData);
        return $data;
	}


	//获得假的密钥
	private function getsecret(){
		$url = "http://mmhallapi.mmpkk.com:8889/secret_t";
		return $this->send($url,[],'POST');
		//print_r($secret);
	}


	function object2array($object) {
		if (is_object($object)) {
			foreach ($object as $key => $value) {
				$array[$key] = $value;
			}
		}
		else {
			$array = $object;
		}
		return $array;
	}

	//拼接真的密钥
	public function getcode(){
		$code = $this->getsecret();
		$token = $this->object2array(json_decode($code[0]));
		//print_r($token);die;

		if($token['code'] != 0){
			return 0;
		}
		$secret = trim($token['dataObject']);
		$index = substr($secret,strlen($secret)-1);
		$split = substr($secret,$index,1);
		$sarr = explode($split,$secret);
		return $sarr[1].'N'.$sarr[0];

	}

	public function userinfoAction(){
		$url = "http://mmhallapi.mmpkk.com:8889/query/getuserinfos";
		$sign_arr = ["memberId"=>10500];
		//echo $this->getcode();die;
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		print_r($res);
	}

	public function rechargeAction(){
		$url = "http://mmhallapi.mmpkk.com:8889/consume/addroomcards";
		//echo '{"memberId": "10214", "beans": 3}vc'.md5('{"memberId": "10214", "beans": 3}'.$this->getcode());
		$sign_arr = ["memberId"=>10500,"beans"=>3];
		echo md5('{"memberId":10500,"beans":3}'.$this->getcode());
		$json_str = implode(': ',explode(':',json_encode($sign_arr))).'vc'.md5(implode(': ',explode(':',json_encode($sign_arr))).$this->getcode());
		//echo $json_str;die;
		echo json_encode($sign_arr);
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		print_r($res);
	}

	public function playlogAction(){
		$url = "http://mmhallapi.mmpkk.com:8889/query/getBattleRecord";
		//echo '{"memberId": "10214", "beans": 3}vc'.md5('{"memberId": "10214", "beans": 3}'.$this->getcode());
		$sign_arr = ["memberId"=>10500];
		//$json_str = implode(': ',explode(':',json_encode($sign_arr))).'vc'.md5(implode(': ',explode(':',json_encode($sign_arr))).$this->getcode());
		$json_str = json_encode($sign_arr).'vc'.md5(json_encode($sign_arr).$this->getcode());
		echo $json_str;die;
		echo json_encode($sign_arr);
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		print_r($res);
	}

	//MARK:- 开始测试
	
	public function unionUsersAction(){
		$this->beginSubTest();
		
		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
			$this->runTest( "guild/channle" ,
			
			$this->commonSignData([
				'channel' => false,
				'start_time' => "2017-11-28 11:00:33" ,
                'end_time'=>"2017-12-19 08:35:05" ,
                'projectname'=>'guild',
                "page"=>1,
                "page_size"=>10
			] ,[

			]),
				
			"渠道用户 列表",
			[
//				"0+ktuid+"=> ["==", "111984469534"] ,
//				"0+username+"=>["==", "wlz820720"],
			],
			"rpc",
            "getChannleUserList"
		);
		
		$this->endSubTest();
	}

	//订单列表
	public function orderListAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "guild/channle" ,

						$this->commonSignData([
								'appid' => '321331',
								'channel' => "ktcs",
								'start_time' => "2017-11-14 08:35:05" ,
								'end_time' => "2017-12-19 08:35:05" ,
								'projectname'=>'guild'

						] ,[

						]),

						"订单 列表",
						[
								//"0+ktuid+"=> ["==", "111984469534"] ,
								//"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"Getorderlist"
				);

		$this->endSubTest();
	}


	//增加返利
	public function adddiscountAction(){

		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "guild/channle" ,

						$this->commonSignData([
								'channel_id' => 120,
								'game_channel' => "ktcs10" ,
								'appid'=>1020,
								'gonghui_discount'=>1,
								'open_flag'=>1,
								'plattype'=>1,

							//
								'act_auth'=>'测试',
								'url'=>'testadddiscount',
								'projectname'=>'guild'
						] ,[

						]),

						"添加 返利",
						[
							//"0+ktuid+"=> ["==", "111984469534"] ,
							//"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"adddiscount"
				);

	}


	//修改、删除返利（删除时，只需传id以及status等于0即可）
	public function updiscountAction(){


		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "guild/channle" ,

						$this->commonSignData([
								'id'=>24,
								'channel_id' => 117,
								'game_channel' => "ktcs7" ,
								'appid'=>1015,
								'gonghui_discount'=>0.5,
							//
								'act_auth'=>'测试',
								'url'=>'testupdiscount',
								'projectname'=>'guild'
						] ,[

						]),

						"修改 返利",
						[
							//"0+ktuid+"=> ["==", "111984469534"] ,
							//"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"Updatediscount"
				);
	}


	//添加渠道
	public function addchannelAction(){

		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "guild/channle" ,

						$this->commonSignData([
								'channel_name' => "开天创世" ,
								'appid'=> 1017,
								'channel'=>'ktcs7',
								'plattype'=>2,
								'open_flag'=>1,
								'channel_type'=>'gonghui',

							//
								'act_auth'=>'测试',
								'url'=>'testaddgonghuichannel',
								'projectname'=>'guild'
						] ,[

						]),

						"添加 渠道",
						[
							//"0+ktuid+"=> ["==", "111984469534"] ,
							//"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"addgonghuichannel"
				);

	}

	//修改渠道
	public function upchannelAction(){

		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "guild/channle" ,

						$this->commonSignData([
								'channel_id' => 115,
								'channel'=>'ktcs5',
								'plattype'=>2,
								'open_flag'=>'1',
								'channel_type'=>'1',

							//
								'act_auth'=>'测试',
								'url'=>'testupgonghuichannel',
								'projectname'=>'guild'
						] ,[

						]),

						"修改 渠道",
						[
							//"0+ktuid+"=> ["==", "111984469534"] ,
							//"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"Updategonghuichannel"
				);

	}


	public function byNameAction(){
		$this->beginSubTest(); 
		
		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
			$this->runTest( "iuserplat/byName" ,
			
			$this->commonSignData([
				'user_name' => "_test__101", 
			] ),
				
			"获取用户",
			[
				"root+user_id+"=>  1,
				"root+user_name+"=>["==", "_test__101"] ,
			],
			"GET"
		); 
		
		$this->endSubTest();
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
		#$this->byNameAction();
		//$this->unionUsersAction();

		$this->orderListAction();
		$this->gameListAction();
		//$this->orderListAction();
		//$this->updiscountAction();
	}
	
	/*
	*	http://icenter.netkingol.com/iuserplat_test?d&k
	*/
	public function indexAction(){ 
		$this->test(); 	
	}

	//游戏列表
	public function gameListAction(){
		$this->beginSubTest();

		list ($recvedOK,$recvCode,$recvMsg,$recvData)=
				$this->runTest( "payrpc/payrpc" ,

						$this->commonSignData([
								'type' => 1,
								'appid' => 321137,
								'pid' => 0,
						] ,[

						]),

						"游戏 列表",
						[
//				"0+ktuid+"=> ["==", "111984469534"] ,
//				"0+username+"=>["==", "wlz820720"],
						],
						"rpc",
						"getArea"
				);

		$this->endSubTest();
	}
	
}