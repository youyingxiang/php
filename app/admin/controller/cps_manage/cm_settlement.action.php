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

class cm_settlementController extends cps_commonController{
    public function indexAction(){
        if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
            $this->error('您没有权限进行此操作','index.php');
            exit;
        }
        //$this->assign("menu", "cps_manage/menu");
        $this->assign("js", "cps_manage/cm_settlement_list.js");
        $_SESSION['agent_id'] = @$_GET['agent_id'];
// 		$agent_unions = self::getAgentUnions($agent_id) ;
// 		$agent_games =  self::getUnionGames($agent_unions) ;
//
        $this->assign("js_para", json_encode(array(
            "games"=> $_SESSION['allgames'] ,
            "unions"=> $_SESSION['allunions'] ,
            "agent_view"=> false,
            "controller_url"=>"index.php?m=cps_manage&c=cm_settlement"
        )));

        $this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));

        $this->assign("title", '代理商结算管理');
        $this->render(false,"common_list.tpl");
    }
    // ALTER TABLE `opentool.netkingol.com`.`tb_settlement` ADD COLUMN `reason` varchar(255) NOT NULL DEFAULT '' AFTER `union_id`;
    public function settlement_ajaxAction(){
        $db = Doris\DApp::loadDT();

        $editor = Editor::inst( $db, 'tb_settlement','settlement_id'  )
            ->fields(
                Field::inst( 'agent_id' ) ,
                Field::inst( 'settlement_no' ) ,
                Field::inst( 'application_time' )->getFormatter(function ($val, $data, $field) {
                    return date("Y-m-d H:i:s",$val);
                }) ,
                Field::inst( 'processing_time' )->getFormatter(function ($val, $data, $field) {
                    return date("Y-m-d H:i:s",$val);
                }),
                Field::inst( 's_status' ),
                Field::inst( 'settlement_amount' ),
                Field::inst( 'refuse_msg' ),
                Field::inst( 'settlement_id' )
            );
        if(@$_SESSION['agent_id'] != ''){
            $editor	->where("agent_id",$_SESSION['agent_id'],"=");
        }
        //此处无用
//        $res = $this->getChildrenAndMyIds($_SESSION['admin']['id']);
//        $agent_unions = $this->getAgentsUnions($res);
//        $editor->where(function($q) use($agent_unions ) {
//            $union_ids = array_keys( $agent_unions );
//            $union_ids = implode(",", $union_ids );
//            if(!empty($union_ids) ){
//                $q->where('union_id', "( $union_ids) ", 'IN', false);
//            }
//        });
        if(in_array(@$_POST['action'] , [ 'edit','create'] ) ) {

            foreach( $_POST['data'] as $key => &$row ){

                // 记LOG
                $log_title = "代理商：$agent_id 申请结算";

                self::logOperation($log_title,
                    ["withdraw_info"=>$_POST ],
                    [],
                    "CA_申请结算" );
            }
        }
        $editor->process( $_POST ) ->json();
    }

    public function ordersAction(){
        $agent_id = $_GET['agent_id'];
        $m = $_GET['m'];
        $_SESSION['settlement_id'] = $_GET['settlement_id'] ;
        $this->order_d($agent_id,$_SESSION['settlement_id'],$m);

    }

    public function orders_ajaxAction(){
        $agent_id = $_GET['agent_id'];
        $agentUnions = self::getAgentUnions($agent_id);
        $this->appordersEditorData( $_SESSION['settlement_id'],$agentUnions );
    }

    /**
     *	拒绝结算
     **/
    public function deny_settlementAction(){
        $id = @(int)$_GET['settlement_id'];
        if( empty($id )  ){
            echo json_encode( ["code"=>1, "msg"=>"settlement_id 不能为空"] ); exit;
        }
        $refuse_msg = @$_GET['refuse_msg'];

        $settle_info = 		Doris\DDB::fetch( "select * from tb_settlement where settlement_id = '$id' " );

        if( $settle_info['s_status'] != 1) {
            echo json_encode( ["code"=>3, "msg"=>"当前状态：". $settle_info['s_status']." 不支持本操作"] ); exit;
        }
        $agent_id = $settle_info['agent_id']  ;

        // 更新结算定单状态
        $now_string = time();
        $sql = "update tb_settlement set `s_status` = 2 , processing_time='$now_string' , `refuse_msg`='$refuse_msg'  where settlement_id = '$id'";
        $data = Doris\DDB::execute($sql );

        //更新订单状态
        $order_sql = "update tb_order set `settle_status` = 0  where settlement_id = '$id'";
        $order_data = Doris\DDB::execute($order_sql );

        $settle_info_after = 	Doris\DDB::fetch( "select * from tb_settlement where settlement_id = '$id' " );

        // 记LOG
        $log_title = "拒绝代理商：$agent_id 结算,  结算id：{$id}，原因：{$refuse_msg}";

        self::logOperation($log_title,
        ["settle_info"=>$settle_info ],
        ["settle_info"=>$settle_info_after ],
        "CM_拒绝结算",[ $refuse_msg ] );

        echo json_encode( ["code"=>0, "msg"=>"成功" ]);
    }
    /**
     *	确认完成结算
     **/
    public function confirm_settlementAction(){

        $id = @(int)$_GET['settlement_id'];
        if( empty($id )  ){
            echo json_encode( ["code"=>1, "msg"=>"id 不能为空"] ); exit;
        }

        $settle_info = Doris\DDB::fetch( "select * from tb_settlement where settlement_id = '$id' " );
        if( $settle_info['s_status'] != 1) {
            echo json_encode( ["code"=>3, "msg"=>"当前状态：". $settle_info['s_status']." 不能结算"] ); exit;
        }

        $agent_id = $settle_info['agent_id']  ;
        $amount = $settle_info['settlement_amount']  ;

        $agent_info = Doris\DDB::fetch( "select user_coins from tb_sys_user where id = '$agent_id' " );
//
//        if(  $agent_info['user_coins']  < $amount){
//            echo json_encode( ["code"=>2, "msg"=>"平台币余额不足"] ); exit;
//        }

        //开始结算
        // 减去加平台币
//        $sql = "update tb_sys_user set `user_coins` = `user_coins`-'$amount' where id = '$agent_id' ";
//        $data = Doris\DDB::execute($sql );

        // 更新结算定单状态
        $now_string = time();
        $settle_sql = "update tb_settlement set `s_status` = 3 , processing_time='$now_string' where settlement_id = '$id'";
        $settle_data = Doris\DDB::execute($settle_sql );
        $order_sql = "update tb_order set `settle_status` = 1 where settlement_id = '$id'";
        $order_data = Doris\DDB::execute($order_sql );

        $agent_info_after = Doris\DDB::fetch("select user_coins from tb_sys_user where id = '$agent_id' ");
        $settle_info_after = Doris\DDB::fetch( "select * from tb_settlement where settlement_id = '$id' " );

        // 记LOG
        $log_title = "给代理商：$agent_id 结算：{$amount}， 结算id：{$id}";

        self::logOperation($log_title,
            ["settle_info"=>$settle_info,"agent_info"=>$agent_info],
            ["settle_info"=>$settle_info_after,"agent_info"=>$agent_info_after],
            "CM_完成结算" );

        echo json_encode( ["code"=>0, "msg"=>"成功", "data"=> $amount ]);

    }

}