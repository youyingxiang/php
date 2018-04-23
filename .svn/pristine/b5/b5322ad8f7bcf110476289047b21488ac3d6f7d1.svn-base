<?php
use Doris\DApp,
		Doris\DCache,
		Doris\DLog,
		app\source\phprpc\PHPRPC_Client,
		Doris\DConfig;


class momoController extends TestLib_Test {
	private $KEY;
	private $iuser_conf;
	private $api_url;
	public function __construct(){

		header("Content-type: text/html; charset=utf-8");
		$this->iuser_conf = DConfig::get("iuser");
		$this->api_url = DConfig::get("api_url");
		$this->KEY = $this->iuser_conf["keys"]['guild'];
		$this->setHost($this->iuser_conf['host']."/");

		$this->setRecvInfoOnREST("msg_code","msg_result","data");

		#$this->afterTest();
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
		$url = $this->api_url."/secret_t";
		return $this->isend($url,[],'','POST');
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
	//测试
	public function test_userinfo($sign_arr){
		$url = $this->api_url."/query/getuserinfos";
		//echo $this->getcode();die;
		$res = $this->test_isend($url,$sign_arr,'POST');
		return $res[0];
	}
	public function userinfo($sign_arr){
		$url = $this->api_url."/query/getuserinfos";
		//echo $this->getcode();die;
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $res[0];
	}

	//测试
	public function test_recharge($sign_arr){
		$url = "http://192.168.1.111:8890/charge";
		$res = $this->test_isend($url,$sign_arr,'POST');
		return $this->object2array(json_decode($res[0]));
	}

	public function recharge($sign_arr){
		$url = "http://houtaiapi.mmpkk.com:8890/charge";
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $this->object2array(json_decode($res[0]));
	}

	/****/
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

	/****/
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


	/** 游戏列表 **/
	public function test_gamelist(){
		$url = "http://192.168.1.111:8890/query/getgamelist";
		$res = $this->test_isend($url,[],'POST');
		return $this->object2array(json_decode($res[0]));
	}

	public function gamelist(){
		$url = "http://houtaiapi.mmpkk.com:8890/query/getgamelist";
		$res = $this->isend($url,[],$this->getcode(),'POST');
		return $this->object2array(json_decode($res[0]));
	}


	/** 检测用户是否存在 **/
	public function test_userext($sign_arr){
		$url = "http://192.168.1.111:8890/check_user_exist";
		$res = $this->test_isend($url,$sign_arr,'POST');
		return $this->object2array(json_decode($res[0]));
	}

	public function userext($sign_arr){
		$url = "http://houtaiapi.mmpkk.com:8890/query/check_user_exist";
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $this->object2array(json_decode($res[0]));
	}

	/** 创建俱乐部 **/
	public function test_clubadd($sign_arr,$path){
		$url = "http://192.168.1.111:8890/create_club/$path";
		$res = $this->test_isend($url,$sign_arr,'POST');
		return $this->object2array(json_decode($res[0]));
	}

	public function clubadd($sign_arr,$path){
		$url = "http://houtaiapi.mmpkk.com:8890/create_club/$path";
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $this->object2array(json_decode($res[0]));
	}


	/** 获取对战记录 **/
	public function test_play($sign_arr){
		$url = "http://192.168.1.111:8890/query/getbattlerecord";
		$res = $this->test_isend($url,$sign_arr,'POST');
		return $this->object2array(json_decode($res[0]));
	}

	public function play($sign_arr){
		$url = "http://houtaiapi.mmpkk.com:8890/query/getbattlerecord";
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		return $this->object2array(json_decode($res[0]));
	}


}