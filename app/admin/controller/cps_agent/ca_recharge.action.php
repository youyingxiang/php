<?php
    	
use DataTables\Editor,
DataTables\Editor\Field,
DataTables\Editor\Format,
DataTables\Editor\Join,
DataTables\Editor\Mjoin,
DataTables\Editor\Validate;

_load("Service_IGame");
/**
 * @Description 管理
 * 
 */

Doris\DApp::loadController("common","cps_common");

class ca_rechargeController extends cps_commonController{
	private $game; //封装game接口对象

	public function __construct(){
		parent::__construct();
		$this->game = new Service_IGame();
	}

	public function indexAction(){
		//echo 111;die;
		//print_r(array_keys($_SESSION['myunions']));
		$myunion = array_keys($_SESSION['myunions']);
		//print_r($myunion);die;
//		if(count($myunion)>0){
//			$this->error('您没有权限进行此操作','index.php');
//			exit;
//		}
		$union = trim(implode(',',$myunion),',');
		$reba_sql = "select agent_discount from tb_pay_rebate_ratio where channel_id in ( $union )";
		$rebate = Doris\DDB::fetchAll($reba_sql);
		//print_r($rebate);die;
		$this->assign("title", _lan('BackgroundUserManagement','CPS代理商充值'));
		$this->assign("rebate",$rebate);
		$this->render("ca_recharge.tpl");
	}

	public function recharge_payAction(){
		//echo dirname(__FILE__);
		require_once dirname(__FILE__).'/../../../lib/config.php';
		require_once dirname(__FILE__).'/../../../lib/aliservice/AlipayTradeService.php';
		require_once dirname(__FILE__).'/../../../lib/buildermodel/AlipayTradePagePayContentBuilder.php';

		//商户订单号，商户网站订单系统中唯一订单号，必填
		$out_trade_no = trim('123123');

		//订单名称，必填
		$subject = trim('123123');

		//付款金额，必填
		$total_amount = 1;

		//商品描述，可空
		$body = trim('1231231');

		//构造参数
		$payRequestBuilder = new AlipayTradePagePayContentBuilder();
		$payRequestBuilder->setBody($body);
		$payRequestBuilder->setSubject($subject);
		$payRequestBuilder->setTotalAmount($total_amount);
		$payRequestBuilder->setOutTradeNo($out_trade_no);
		$aop = new AlipayTradeService($config);

		/**
		 * pagePay 电脑网站支付请求
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @param $return_url 同步跳转地址，公网可以访问
		 * @param $notify_url 异步通知地址，公网可以访问
		 * @return $response 支付宝返回的信息
		 */
		$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

		//输出表单
		var_dump($response);
	}

	//游戏区、服列表
	public function game_listAction(){
		$game_id = $_GET['game_id'];
		$pid = $_GET['pid'];
		$game = $this->game->gameList(1,$game_id,$pid);
		//echo $game_id;die;
		$str = '<option value="0">请选择</option>';
		//print_r($game);die;
		if($game[1]=20000){
			foreach($game[3] as $v){
				$str .= '<option value='.$v['server_id'].','.$v['name'].'>'.$v['name'].'</option>';
			}
			echo $str;
		}
	}

	public function check_roleAction(){
		$ktuid = $_GET['ktuid'];
		$server = explode(',',$_GET['server']);
		$appid = $_GET['appid'];
		//echo $server[0].$server[1];die;
		//$roleinfo = $this->game->userRoleAction(1,$appid,$ktuid,$server[0],$server[1]);
		$roleinfo = $this->game->userRole(1,'321137','14','9011','安卓测试');
		//print_r($roleinfo);die;
		if($roleinfo[1]=20000){
			echo $roleinfo[3]['rolename'];
		}
	}

	public function goodsAction(){
		$appid = $_GET['appid'];
		$goodslist = $this->game->shopList(1,'321137');
		$str = '';
		if($goodslist[1]=20000){
			foreach($goodslist[3] as $v){
				$str .= '<option value='.$v['goodsid'].','.$v['goodsname'].','.$v['price'].'>充'.$v['price'].'送'.$v['goodsname'].'</option>';
			}
			echo $str;
		}
	}
}