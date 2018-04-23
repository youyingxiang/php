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
	 //执行返利
    public function dobate($order_sn){
        $order_sn = $order_sn;
        $m_rate = new Mobile_RebateModel();
        $m_user = new Mobile_UserModel();
        $order = \Doris\DDB::fetch("select * from tb_recharge_order where order_sn='".$order_sn."'");
        //关联代理的id
        $leader = $m_rate->get_leaderid($order['userid']);
        $data = $this->getparents($leader);  //该用户的所有上级
     	$data_0 = $data[0];   //找到他的主管副主管之类的
     	$data_1 = $data[1];
     	$order['amount'] = $order['goods_name']/2;

        //if ($data_prev['user_level'] == )
        $i = 0;
        //返房卡
        foreach ($data_1 as $key => $value) {
        	$m_rate->go_rebate($order['goods_name'],$order['userid'],$value['id'],$i);
        	$i++;
        }
      	//返金额
        foreach ($data_0 as $key => $value) {
        	$m_rate->go_rebate_money($order['amount'],$order['userid'],$value['id'],$value['user_level'],$leader);
        	$i++;
        }
        // for($i=0;$i<3;$i++){
        //     
        //     $new_id = $m_rate->get_leaderid($id);
        //     dd($new_id);
        //     $id = $new_id;
        // }


    }
    public function getparents($id)
    {
        $data = \Doris\DDB::fetchAll("select * from tb_sys_user");            //获取所有返卡的用户
        return $this->_parent($data, $id);
    }

    private function _parent($data, $parent_id=0,$level=0)
    {
        static $list = [];
        static $val = [];
        foreach ($data as $k =>$v) {
            if ($v['id'] == $parent_id) {
            	if ($v['user_level'] != 1) {   //说明遇到了主管副主管了
            		$v['level'] = $level;
            		$this->_parent($data,$v['leader'],$level+1);
	        		$val[] = $v;
	        		break;
	        	} else {
	                $v['level'] = $level;
	                $this->_parent($data,$v['leader'],$level+1);
	                if (count($list)<2) {
	                	$list[] = $v;
	                }
            	}
            }
        }
        krsort($list);
     	return array($val,$list);
    }
	public function confAction($para){
		$conf =  	Doris\DConfig::get();
		echo "<pre>";
		print_r($conf["push"]);
		print_r($conf["dispatch"]);
	}
}










