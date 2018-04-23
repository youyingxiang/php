<?php 
/**
 * 访问IGame接口基类
 * @author qiaochenglei
 * 2017-04-29
 * 
 *
 */ 
 
use Doris\DApp,
 Doris\DCache,
 Doris\DLog,
 app\source\phprpc\PHPRPC_Client,
 Doris\DConfig;
 
require _THIRD_DIR_.'rpc/phprpc_client.php';
class Service_IGameBase{
	protected $KEY;
	protected $SECRET;
	
	
	protected $codeNameOnPost ;
	protected $msgNameOnPost ;
	protected $dataNameOnPost ;
	
	protected $igame_conf;

	
	public function __construct($codeNameOnPost="msg_code" ,$msgNameOnPost = "msg_result", $dataNameOnPost ="data" ){
        $this->setRecvInfoOnREST($codeNameOnPost, $msgNameOnPost,  $dataNameOnPost);
        
       	$this->igame_conf = DConfig::get("igame");
    }
	
	//当测试的是 POST 时,要设置返回码 code、msg、data的名称
	public function setRecvInfoOnREST($codeName,$msgName,$dataName){
		$this->codeNameOnPost=$codeName;
		$this->msgNameOnPost=$msgName;
		$this->dataNameOnPost=$dataName;
	}
	
	protected function _getSign( $data){
        ksort($data);
        $pair = array();
        foreach($data as $k => $v){
            if($v==''){
                continue;
            }
            $pair[] = $k.'='.$v;
        }
        $str = implode('#', $pair);
        #echo $str.$this->KEY;exit;
        $sign = md5($str.$this->KEY);
        return $sign;
	}
	protected function commonSignData($exData = [],$notSignData=[]){
		$data = $exData ;
		$data["sign"] = $this->_getSign($data);
		//之后字段不参与签名
		$data = array_merge($data, $notSignData);
		return $data;
	}



	public function sendIGame($key_index, $interface , $sign_arr,$not_sign_arr = [],$action){
		$this->KEY = $this->igame_conf["keys"][$key_index];
        $sign_arr['projectname'] = $key_index;
	 	$reqData = $this->commonSignData($sign_arr , $not_sign_arr);
		$r = $this->sendCommon(
			$this->igame_conf["host"]."/". $interface,
			$reqData,
            $action
		);
		self::log($r[1],$r[2],$r[3], $interface,$reqData);
		return $r; 
	}
	//TODO:要记录LOG
	protected function sendCommon($url,$para,$action){
        $raw =self::send($url,$para,$action );
		$r=$raw ? json_decode($raw,true):array();
		//var_dump($r);
		$recvedOK=!empty($raw);
		
		$recvCode=$raw? (isset($r[$this->codeNameOnPost])?$r[$this->codeNameOnPost]: 700 ):-1;
		$recvMsg= $raw? (isset($r[$this->msgNameOnPost])?$r[$this->msgNameOnPost]:"lost field: $this->msgNameOnPost "):"net unreachable!";
		$recvData=$raw? (isset($r[$this->dataNameOnPost])?$r[$this->dataNameOnPost]:null):null;
		
		return [$recvedOK,$recvCode,$recvMsg,$recvData,$raw];
	}
	
	public static function send($url, $data,$action) {
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client($url);

        $res = $client->$action($data);
        return $res;
    }
	
	//
	 
	public static function log( $code,$msg,$data,$interface, $reqData ){
		_load( "Admin_ActionLogModel"); 
		$newcamera = [];
		if(  !empty($data['root']) &&  is_array($data['root'])  ){
	 		$newcamera=  ["返回的是数组，COUNT为"=>count($data['root'])];
		}else{
			$newcamera =  $data ; 
		} 
		$log=[$msg];
		Admin_ActionLogModel::log(-1 ,"console_auto","自动调用".$interface,$reqData,$newcamera,$log , $interface , "ICenterCall") ;
	}
}


