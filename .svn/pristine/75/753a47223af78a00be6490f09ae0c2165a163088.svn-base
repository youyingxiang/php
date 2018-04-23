<?php

use DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Join,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Validate;


/**
 * @Description 管理
 *
 */

Doris\DApp::loadController("common","cps_common");

class ca_applyController extends cps_commonController{
    public function indexAction(){
        //print_r($_SESSION);die;
        $this->assign("second_menu", "new_button.tpl");
        $this->assign("js", "cps_agent/ca_apply_list.js");
        $this->assign("js_para", json_encode(array(
            "games"=> $_SESSION['mygames'] ,
            "unions"=> $_SESSION['myunions'] ,
            "settle_time" => $this->settle_time(),
            "controller_url"=>"index.php?m=cps_agent&c=ca_apply",
            "agent_id"=>@(int)$_SESSION['admin']['id'],
        )));
        $this->assign('settle_time',$this->settle_time());
        $this->assign('agent_id',@(int)$_SESSION['admin']['id']);
        $cur_coins = $this->currentCoins();
        $this->assign("title", "申请结算");//<small> 余额：$cur_coins</small>
        $this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
        $this->render(false,"common_list.tpl");
    }
    private function currentCoins(){
        $id = @(int)$_SESSION['admin']['id'];
        $user_info = Doris\DDB::fetch( "select user_coins from tb_sys_user where id = '$id' " );
        return $user_info['user_coins'];

    }
    public function apply_ajaxAction(){

        $db = Doris\DApp::loadDT();
        $agent_id = @(int)$_SESSION['admin']['id'];
        $cur_coins = $this->currentCoins();
        $editor = Editor::inst( $db, 'tb_settlement','settlement_id'  )
            ->fields(
                Field::inst( 'settlement_id' ),
                Field::inst( 'start_time' ),
                Field::inst( 'settlement_no' ),
                Field::inst( 'application_time' )->getFormatter(function ($val, $data, $field) {
                    return date("Y-m-d H:i:s",$val);
                }),
                Field::inst( 'refuse_msg' ),
                Field::inst( 's_status' ),
                Field::inst( 'settlement_amount' )
                    ->validator( 'Validate::maxNum', array( 'max'=> $cur_coins  ) ),
                Field::inst( 'agent_id' )
            );

        $editor->where("agent_id",@(int)$_SESSION['admin']['id']);

        //print_r($_POST);exit;
        //确保角色信息不能为空
//        if(in_array(@$_POST['action'] , [ 'create'] ) ) {
//
//            $_POST['data'][0]['settlement_no'] = $this->new_code();
//            $_POST['data'][0]['application_time'] = time();
//            $_POST['data'][0]['s_status'] = 1;
//            $_POST['data'][0]['settlement_amount'] = $this->settle_money($_SESSION['myunions']);
//
//            //改变订单状态
//            $res = $editor->process( $_POST )->data();
//            if($res['data'][0]['settlement_id']){
//                // 记LOG
//                $log_title = "代理商：$agent_id 申请结算";
//                self::logOperation($log_title,
//                    ["apply" => $_POST],
//                    [],
//                    "CA_申请结算");
//                #$this->change_state($res['data'][0]['settlement_id']);
//                echo json_encode($res);exit;
//            }
//        }
        //return $_POST;
        $editor->process( $_POST ) ->json();
    }

    public function apply_showAction(){
        $data['settlement_no'] = $this->new_code();
        $data['application_time'] = time();
        $data['s_status'] = 1;
        //$data['settlement_amount'] = $this->settle_money($_SESSION['myunions']);
        $data['start_time'] = $_GET['start_time'];
        $data['agent_id'] = $_GET['agent_id'];
        $check = Doris\DDB::fetch( "select count(*) as count from tb_settlement where s_status in (1,3) and start_time='".$data['start_time']."' and agent_id=".$data['agent_id'] );
        if( $check['count'] >0 ){
            $this->error('已有申请中的结算单','index.php?m=cps_agent&c=ca_apply');
        }
        $this->redirect('index.php?m=cps_agent&c=ca_apply&a=showorders&agent_id='.$data['agent_id'].'&start_time='.$data['start_time'].'&agent_id='.$data['agent_id']);
    }

    public function apply_addAction(){
        $data['settlement_no'] = $this->new_code();
        $data['application_time'] = time();
        $data['s_status'] = 1;
        //$data['settlement_amount'] = $this->settle_money($_SESSION['myunions']);
        $data['start_time'] = $_GET['start_time'];
        $data['agent_id'] = $_GET['agent_id'];
        $check = Doris\DDB::fetch( "select count(*) as count from tb_settlement where s_status in (1,3) and start_time='".$data['start_time']."' and agent_id=".$data['agent_id'] );
        if( $check['count'] >0 ){
            $this->error('已有申请中的结算单','index.php?m=cps_agent&c=ca_apply');
        }
        $res = Doris\DDB::add('tb_settlement',$data);
        if($res['last_id']){
            $this->change_settle_id($res['last_id'],$_SESSION['myunions']);
            $this->change_state($res['last_id']);
            $this->success('申请结算成功，请勿重新申请！','index.php?m=cps_agent&c=ca_apply&a=orders&agent_id='.$data['agent_id'].'&settlement_id='.$res['last_id']);
        }
    }

    //改变状态
    private function change_state($settlement_id){
        $where = ' where payState=3 and settle_status=0 ';
        $union_pairs = $_SESSION['myunions'];
        $union_ids = array_keys($union_pairs);
        if($union_ids){
            $union_ids = implode(",", $union_ids );
            $where .= " and union_id in ($union_ids)";
        }else{
            $where .= " and 1=-1 "; //表明用户没有渠道
        }
        $date_sql = "select start_time from tb_settlement where settlement_id=$settlement_id";
        $settle_data = Doris\DDB::fetch($date_sql);

        if(!empty($settle_data['start_time'] ) && @strtotime($settle_data['start_time'] ) ){
            $where .= " and DATE_FORMAT( payOrderTime, '%Y-%m-%d') >= '".date('Y-m-d',strtotime($settle_data['start_time']))."'";
            $time_to = $settle_data['start_time'].'-32';
            if(!empty($time_to )){
                $where .= " and DATE_FORMAT( payOrderTime, '%Y-%m-%d') < '".$time_to."' ";
            }
        }
        //$sql = "select sum(amount) amount from tb_order $where";
        //echo $sql;die;
        $sql = "update tb_order set settle_status=2,settlement_id=$settlement_id $where";
        $res = Doris\DDB::execute($sql);


        //记录结算单的总金额
        if($res){
            //$where = str_replace("settle_status=0","settle_status=2",$where);
            $where1 = ' where uorder.payState=3 and uorder.settle_status=2 ';
            $union_pairs = $_SESSION['myunions'];
            $union_ids = array_keys($union_pairs);
            if($union_ids){
                $union_ids = implode(",", $union_ids );
                $where1 .= " and unoins.union_id in ($union_ids)";
            }else{
                $where1 .= " and 1=-1 "; //表明用户没有渠道
            }
            $date_sql = "select start_time from tb_settlement where settlement_id=$settlement_id";
            $settle_data = Doris\DDB::fetch($date_sql);

            if(!empty($settle_data['start_time'] ) && @strtotime($settle_data['start_time'] ) ){
                $where1 .= " and DATE_FORMAT( uorder.payOrderTime, '%Y-%m-%d') >= '".date('Y-m-d',strtotime($settle_data['start_time']))."'";
                $time_to = $settle_data['start_time'].'-32';
                if(!empty($time_to )){
                    $where1 .= " and DATE_FORMAT( uorder.payOrderTime, '%Y-%m-%d') < '".$time_to."' ";
                }
            }

            $sqlo = "select  uorder.amount,ratio.agent_discount from tb_order as uorder left join tb_sys_user_union as unoins on uorder.union_id=unoins.union_id left join tb_pay_rebate_ratio as ratio on uorder.union_id=ratio.channel_id $where1 and unoins.user_id=".$_SESSION['admin']['id'];
            $order = Doris\DDB::fetchAll($sqlo );
            $data = ['deduct'=>0];
            foreach($order as $v){
                $data['deduct'] += $v['amount'] * $v['agent_discount'];
            }

            Doris\DDB::execute("update tb_settlement set settlement_amount=".$data['deduct']." where settlement_id=$settlement_id");
        }
    }

    public function ordersAction(){
        $agent_id = $_GET['agent_id'] ;
        $m = $_GET['m'];
        $_SESSION['settlement_id'] = $_GET['settlement_id'] ;
        $this->order_d($agent_id,$_SESSION['settlement_id'],$m);
    }

    public function showordersAction(){
        $_SESSION['start_time'] = $_GET['start_time'];
        $_SESSION['agent_id'] = $_GET['agent_id'];
        $this->assign("second_menu", "show_order.tpl");
        $this->assign("js", "cps_agent/ca_showorders_list.js");
        $this->assign("js_para", json_encode(array(
            "games"=> $_SESSION['mygames'] ,
            "unions"=> $_SESSION['myunions'] ,
            "controller_url"=>"index.php?m=cps_agent&c=ca_apply",
            "ajax_url"=>"index.php?m=cps_agent&c=ca_apply&a=showorder_ajax",
            "agent_id"=>@(int)$_SESSION['admin']['id'],
        )));

        $this->assign('agent_id',@(int)$_SESSION['admin']['id']);
        $cur_coins = $this->currentCoins();
        $this->assign("title", "结算单详情");
        $this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));
        $this->render(false,"common_list.tpl");
    }

    public function showorder_ajaxAction(){
        $agentUnions = self::getAgentUnions($_SESSION['agent_id']);
        $this->ordertable( $_SESSION['start_time'],$agentUnions );
    }

    public function showorder_calcAction(){
        $agentUnions = self::getAgentUnions($_SESSION['agent_id']);
        echo json_encode($this->settle_money($agentUnions,$_SESSION['start_time']));
    }

    public function orders_ajaxAction() {
        $agent_id = @$_GET['agent_id'];
        $agentUnions = self::getAgentUnions($agent_id);
        $this->appordersEditorData( $_SESSION['settlement_id'],$agentUnions );
    }

    public function apporder_calcAction($m){
        $result = $this->apporder_calc($_SESSION['settlement_id'],$_SESSION['myunions'],$m);
        echo json_encode($result);
    }

    private function new_code(){
        $code = "K".date('YmdHis',time()).mt_rand(1000,10000);
        $check = Doris\DDB::fetchAll("select * from tb_settlement where settlement_no='$code'");
        if (count($check)>0){
            $this->new_code();
        }
        return $code;
    }

    //检查有订单交易的时间段
    private function settle_time(){
        $union_pairs = $_SESSION['myunions'];
        $where = ' where payState=3 and settle_status=0 ';
        $agent_id = $_SESSION['admin']['id'];
        $union_ids = array_keys($union_pairs);
        if($union_ids){
            $union_ids = implode(",", $union_ids );
            $where .= " and union_id in ($union_ids)";
        }else{
            $where .= " and 1=-1 "; //表明用户没有渠道
        }

        $union_id = @$_GET["union_id"];
        if(!empty( $union_id ) ){
            $where .= " and union_id = '$union_id' ";
        }
        $sql = "select * from tb_order $where";
        $arr = Doris\DDB::fetchAll($sql);
        if(count($arr)==0){
            return '';
            exit;
        }
        foreach($arr as $key=>$val){
            if(date('Y-m',strtotime($val['payOrderTime'])) != date('Y-m',time())){
                $v_date[date('Y-m',strtotime($val['payOrderTime']))] = date('Y-m',strtotime($val['payOrderTime']));
            }
        }
        return $this->array2object(array_unique($v_date));
    }

//    public function testAction(){
//        var_dump($this->settle_time());
//    }

    //数组转对象
    private function array2object($array) {
        if (is_array($array)) {
            $obj = new StdClass();
            foreach ($array as $key => $val){
                $obj->$key = $val;
            }
        }
        else { $obj = $array; }
        return $obj;
    }

    //
    private function settle_money($union_pairs,$start_time){
        $where = " where uorder.payState=3 and uorder.settle_status=0 ";
        $union_ids = array_keys($union_pairs);
        if($union_ids){
            $union_ids = implode(",", $union_ids );
            $where .= " and uorder.union_id in ($union_ids)";
        }else{
            $where .= " and 1=-1 "; //表明用户没有渠道
        }

        $union_id = @$_GET["union_id"];
        if(!empty( $union_id ) ){
            $where .= " and uorder.union_id = '$union_id' ";
        }

        if(!empty( $start_time ) ){
            $where .= " and uorder.payOrderTime >= '".date("Y-m-d",strtotime($start_time))."' and uorder.payOrderTime < '".date("Y-m",strtotime($start_time))."-32'";
        }

        $sqlo = "select  uorder.order_id,uorder.amount,ratio.agent_discount from tb_order as uorder left join tb_sys_user_union as unoins on uorder.union_id=unoins.union_id left join tb_pay_rebate_ratio as ratio on unoins.union_id=ratio.channel_id $where and unoins.user_id= ".$_SESSION['admin']['id'];

        $order = Doris\DDB::fetchAll($sqlo );
        $data = ['deduct'=>0,'amount'=>0,'count'=>count($order),'oids'=>''];
        foreach($order as $v){
            $data['deduct'] += $v['amount'] * $v['agent_discount'];
            $data['amount'] += $v['amount'];
            $data['oids'] .= $v['order_id'].',';
        }
        $data['oids'] = trim($data['oids'],',');

            //查询订单的总金额
        //$sql = "select sum(amount) amount,count(*) count,GROUP_CONCAT(DISTINCT(order_id)) oids from tb_order $where";
        $r= date('Y-m',strtotime($start_time));
        //$r= explode("-",date('Y-m',strtotime($start_time)));
//        if($r[1] >= 12){
//            $r[1] = 1;
//            $r[0] = $r[0]+1;
//        }else{
//            $r[1] = $r[1]+1;
//        }
//        $rto = implode('-',$r);
//        $date = $start_time.' - '.$rto;
        // 结算单统计信息
        //$data = Doris\DDB::fetch($sql);
         return ["code"=>0, "msg"=>"", "data"=>$data,"button"=>"未结算,<a style='font-weight:bold;' href='index.php?m=cps_agent&c=ca_apply&a=apply_add&agent_id=".$_SESSION['agent_id']."&start_time=".$start_time."'>马上申请</a>","date"=>$r];
    }

    private function change_settle_id($settlement_id,$union_pairs){
        $where = " where payState=3 and settle_status=0 ";
        $union_ids = array_keys($union_pairs);
        if($union_ids){
            $union_ids = implode(",", $union_ids );
            $where .= " and union_id in ($union_ids)";
        }else{
            $where .= " and 1=-1 "; //表明用户没有渠道
        }

        $union_id = @$_GET["union_id"];
        if(!empty( $union_id ) ){
            $where .= " and union_id = '$union_id' ";
        }
        $date_sql = "select start_time from tb_settlement where settlement_id=$settlement_id";
        $settle_data = Doris\DDB::fetch($date_sql);
        if(!empty($settle_data['start_time'] ) && @strtotime($settle_data['start_time'] ) ){
            $where .= " and payOrderTime >= '".$settle_data['start_time']."'";
            $time_to = $settle_data['start_time'].'-32';
            if(!empty($time_to )){
                $where .= " and payOrderTime < '".$time_to."' ";
            }
        }
        //改变订单的结算id
        $up_sql = "update tb_order set settlement_id=$settlement_id $where";
        return Doris\DDB::execute($up_sql);

    }


    //检查有订单交易的时间段
//	private function check_settle_time(){
//		$agent_id = $_SESSION['admin']['id'];
//		$sql = "select * from tb_order where pay_state=2 and union_id=$agent_id";
//		$arr = Doris\DDB::fetchAll($sql);
//		foreach($arr as $key=>$val){
//			$v_date[date('Y',$val['paid_time'])][] = date('m',$val['paid_time']);
//			$v_date[date('Y',$val['paid_time'])] = array_unique($v_date[date('Y',$val['paid_time'])]);
//		}
//		return json_encode($v_date);
//	}

}