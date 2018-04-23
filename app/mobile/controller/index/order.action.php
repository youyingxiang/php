<?php
use DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Join,
    DataTables\Editor\Validate;

use Doris\DConfig,
    Doris\DCache;



/**
 * @Description 前台用户管理
 *
 */

class orderController extends commonController{
    private $user_Model;
    private $rebate_Model;
    private $count = 3;

    public function __construct(){
        parent::__construct();
        $this->rebate_Model = new Mobile_RebateModel();
        $this->user_Model = new Mobile_UserModel();
    }

    //代理充值订单
    public function up_orderAction(){
        list($room_card,$top_up,$channel_id,$play_type,$button) = array_values($_POST);
        if($button){
            $data = ['goods_name'=>$room_card,
                'amount'=>$top_up,
                'userid'=>$_SESSION['admin']['id'],
                'paytype'=>$play_type,
                'c_time'=>time(),
                'order_sn'=>$this->exten_code()];
            $res = Doris\DDB::add('tb_recharge_order',$data);
            if(!$res) $this->error('当前系统忙，请稍后再试');
            if ($play_type == 1)
                $codeurl = $this->wxpay($res['last_id']);
            else if($play_type == 2)
                $codeurl = $this->zfbpay($res['last_id']);

        }
        $this->assign('goods_name',$room_card);
        $this->assign('amount',$top_up);
        $this->assign('codeurl',$codeurl);
        $this->assign('order_sn',$data['order_sn']);
        $this->assign("public", "public.tpl");
        $this->render('pay_order.tpl');
    }

    private function exten_code(){
        $code = "MM".date('YmdHis',time()).mt_rand(1000,10000);
        $check = Doris\DDB::fetchAll("select * from tb_recharge_order where order_sn='$code'");
        if (count($check)>0){
            $this->exten_code();
        }
        return $code;
    }

    //易宝支付(比较垃圾，慎用)
    private function yeepay($order_id){
        //header('Content-Type: image/png'); //对应jpeg的类型

        require_once dirname(__FILE__).'/../../../lib/yeepay/yeepayMpay.php';
        require_once dirname(__FILE__).'/../../../lib/yeepay/config.php';
        list($merchantaccount,$merchantPrivateKey,$merchantPublicKey,$yeepayPublicKey) = $config;
        $yeepay = new yeepayMpay($merchantaccount,$merchantPublicKey,$merchantPrivateKey,$yeepayPublicKey);
        $order = Doris\DDB::fetch("select * from tb_recharge_order where id=".$order_id);

        $cardno    =  '';
        $idcardtype  =  '';
        $idcard   =  '';
        $owner    =  '';
        $order_id   =  trim($order['order_sn']);       //*
        $transtime   =  intval($order['c_time']);     //*
        $amount    =  0.01/100;//intval($order['amount']*100);       //*
        $currency    =  intval(156);
        $product_catalog =  trim('1');             //*
        $product_name  =  trim($order['goods_name']);         //*
        $product_desc =  trim($order['goods_name']);
        $identity_type   =  intval(1);               //*
        $identity_id     =  trim($_SESSION['admin']['id']);             //*
        $user_ip   =  trim($this->getRealIp());       //*
        $paytool   =  '2';
        $directpaytype   =  intval(2);
        $user_ua    =  '';
        $terminaltype    =  intval(1);           //*
        $terminalid  =  trim('44-45-53-54-00-00');        //*
        $callbackurl  =  '';
        $fcallbackurl  =  '';
        $orderexp_date  =  intval(60);
        $paytypes     = '';
        $version     = '1';
//        echo "cardno:".$cardno.'<br/>';
//        echo "transtime:".$transtime.'<br/>';
//        echo "amount:".$amount.'<br/>';
//        echo "product_catalog:".$product_catalog.'<br/>';
//        echo "product_name:".$product_name.'<br/>';
//        echo "identity_type:".$identity_type.'<br/>';
//        echo "identity_id:".$identity_id.'<br/>';
//        echo "user_ip:".$user_ip.'<br/>';
//        echo "terminaltype:".$terminaltype.'<br/>';
//        echo "terminalid:".$terminalid.'<br/>';
        echo '<br/>order_id='.$order_id.'<br/>transtime='.$transtime.'<br/>amount='.$amount.'<br/>cardno='.$cardno.'<br/>idcardtype='.$idcardtype.'<br/>idcard='.$idcard.'<br/>owner='.$owner.'<br/>product_catalog='.$product_catalog.'<br/>identity_id='.$identity_id.'<br/>identity_type='.$identity_type.'<br/>user_ip='.$user_ip.'<br/>paytool='.$paytool.'<br/>directpaytype='.$directpaytype.'<br/>user_ua='.$user_ua.'<br/>callbackurl='.
        $callbackurl.'<br/>fcallbackurl='.$fcallbackurl.'<br/>currency='.$currency.'<br/>product_name='.$product_name.'<br/>product_desc='.$product_desc.'<br/>terminaltype='.$terminaltype.'<br/>terminalid='.$terminalid.'<br/>orderexp_date='.$orderexp_date.'<br/>paytypes='.$paytypes.
        '<br/>version='.$version;
        $data = $yeepay->webPay($order_id,$transtime,$amount,$cardno,$idcardtype,$idcard,$owner,$product_catalog,$identity_id,$identity_type,$user_ip,$paytool,$directpaytype,$user_ua,
            $callbackurl,$fcallbackurl,$currency,$product_name,$product_desc,$terminaltype,$terminalid,$orderexp_date,$paytypes,$version);
        if( array_key_exists('error_code', $data)) {return false;}

        $img= hex2byte($data['imghexstr']);
        $filename = "qrcode.jpg";    // 写入的文件
        $file = fopen("./".$filename,"w");//打开文件准备写入
        fwrite($file,$img);//写入
        fclose($file);//关闭
        return "<img src=$filename> ";

    }

    public function zfbpay($order_id)
    {
        header("Content-type: text/html; charset=utf-8");
        ini_set('date.timezone','Asia/Shanghai');     
        require_once './webpay/wappay/service/AlipayTradeService.php';
        require_once './webpay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
        require './webpay/config.php';
        $order = Doris\DDB::fetch("select * from tb_recharge_order where id=".$order_id);
        if ( strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
            require_once './webpay/wap_in_weixin/wap_in_weiixn.php';
        }
        $order = Doris\DDB::fetch("select * from tb_recharge_order where id=".$order_id);

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $order['order_sn'];

        //订单名称，必填
        $subject = '摸摸游戏';

        //付款金额，必填
        $total_amount = $order['amount'];

        //商品描述，可空
        $body = '摸摸游戏房卡充值';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $payResponse = new AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
    }

    public function wxpay($order_id){
        ini_set('date.timezone','Asia/Shanghai');
        //error_reporting(E_ERROR);

        require_once dirname(__FILE__)."/../../../lib/wxpay/lib/WxPay.Api.php";
        require_once dirname(__FILE__)."/../../../lib/wxpay/WxPay.NativePay.php";
        require_once dirname(__FILE__)."/../../../lib/wxpay/log.php";

        $order = Doris\DDB::fetch("select * from tb_recharge_order where id=".$order_id);
        $id = $_SESSION['admin']['id'];
        $_SESSION["order_sn_uid".$id] = $order['order_sn'];
        $input = new WxPayUnifiedOrder();
        $notify = new NativePay();
        // echo $order['order_sn'];
        $input->SetBody("摸摸游戏");
        $input->SetAttach("摸摸游戏");
        $input->SetOut_trade_no($order['order_sn']);
        $input->SetTotal_fee($order['amount']*100);
        // $input->SetTotal_fee(0.01*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($order['goods_name']);
        $wechat_notify_url = DConfig::get("wechat_notify_url").$order['order_sn'];
        $input->SetNotify_url($wechat_notify_url);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order['userid']);
        $result = $notify->GetPayUrl($input);
        $url = $result["code_url"];
        return $url;
    }
    public function query_payAction(){
        require_once dirname(__FILE__)."/../../../lib/wxpay/lib/WxPay.Api.php";
        require_once dirname(__FILE__)."/../../../lib/wxpay/lib/WxPay.Notify.php";
        require_once dirname(__FILE__)."/../../../lib/wxpay/log.php";
        $input = new WxPayOrderQuery();
        $order_sn = $_POST['order_sn'];
        $input->SetOut_trade_no($order_sn);
        //更新用户
        $result = WxPayApi::orderQuery($input);
        if ($result['trade_state'] == 'SUCCESS') {
            $this->refreshSESSION();
        }
        echo json_encode($result);
    }

    //执行返利
    public function dobateAction($order_sn){
        $order_sn = "MM201802021951157058";
        //$id = $_SESSION['admin']['id'];
        //上级用户ID
        $id = $this->rebate_Model->get_leaderid($_SESSION['admin']['id']);
        //获取订单信息
        $order = $this->user_Model->getorder($order_sn);
        for($i=0;$i<$this->count;$i++){
            $this->rebate_Model->go_rebate($order['goods_name'],$_SESSION['admin']['id'],$id);

            $new_id = $this->rebate_Model->get_leaderid($id);
            $id = $new_id;
        }


    }


    function getRealIp()
    {
        $ip=false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    //玩家充值订单
    public function uorderAction(){
        //无用
    }

}