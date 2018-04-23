<?php 

	/**
	 *  @Description 返利model类
	 *  
	 * 
	 */

class Mobile_RebateModel{
// 	private $leader;
// //
//     public function __construct(){
// 		$leader = $_SESSION['admin']['parent_id'];
//     }

	public function get_discount($id){
		$sql = "select user_rebate from tb_user_level where id=$id";
		$userbate = Doris\DDB::pdoSlave()->query($sql)->fetch(PDO::FETCH_ASSOC);
		return $userbate['user_rebate'];
	}
 //11
	public function get_leaderid($userid){
		$sql = "select parent_id from tb_sys_user where id=$userid";
		$user = Doris\DDB::pdoSlave()->query($sql)->fetch(PDO::FETCH_ASSOC);
		return $user['parent_id'];
	}
    /**
     * [go_rebate description]
     * @param  [type] $amount [房卡数量]
     * @param  [type] $userid [用户id]
     * @param  [type] $toid   [上级用户id]
     * @param  [type] $i   	  [循环次数]
     */
	public function go_rebate($amount,$userid,$toid,$i){
		//检测如果有
		if($toid>0){
			// $sql = "select user_level from tb_sys_user where id=$toid";
			// $user = Doris\DDB::fetch($sql);
			// $rebate = $this->get_discount($user['user_level']);
			$rebate = $i?0.05:$this->get_discount(1);  //如果$i==0 那么就是直属上级
			//组装数组
			$data = [
				'userid' => $userid,
				'rebate' => $rebate,
				'counts' => $amount * $rebate,
				're_time' => time(),
				'to_id' => $toid
			];

			//添加记录
			$res = Doris\DDB::add('tb_user_rebate',$data);
			if($res){
				//给用户返利
				Doris\DDB::pdoSlave()->query("update tb_sys_user set user_coins=user_coins+".$amount * $rebate." where id=".$toid);

			}
		}

	}
    
}
