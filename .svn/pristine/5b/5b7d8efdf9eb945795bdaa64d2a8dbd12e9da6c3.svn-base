<?php
use Doris\DApp,
    Doris\DCache,
    Doris\DLog,
    app\source\phprpc\PHPRPC_Client,
    Doris\DConfig;

require _THIRD_DIR_.'rpc/phprpc_client.php';
class iuser_testController {
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
	
	//MARK:- 开始测试
	
	public function unionUsersAction(){

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

	public function send($url, $data,$action) {
		$client = new PHPRPC_Client();
		$client->_PHPRPC_Client($url);

		$res = $client->$action($data);
		return $res;
	}

	public function getsecret(){

		$secret = $this->getsecret();
		echo $secret;
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

	public function userinfo($sign_arr){
		$url = "http://mmhallapi.mmpkk.com:8889/query/getuserinfos";
		//echo $this->getcode();die;
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $res[0];
	}

	public function rechargeAction(){
		$url = "http://mmhallapi.mmpkk.com:8889/consume/addroomcards";
		//echo '{"memberId": "10214", "beans": 3}vc'.md5('{"memberId": "10214", "beans": 3}'.$this->getcode());
		$sign_arr = ["memberId"=>10500,"beans"=>3];
		echo md5('{"memberId":10500,"beans":3}'.$this->getcode());
		$json_str = implode(': ',explode(':',json_encode($sign_arr))).'vc'.md5(implode(': ',explode(':',json_encode($sign_arr))).$this->getcode());

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