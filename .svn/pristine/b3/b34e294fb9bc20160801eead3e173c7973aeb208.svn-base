<?php 


class auto_fetchController extends commonController{
 
	 
	public function __construct(){
		//
		
	}

	
	
	/**
	*	自动拉取订单
	*
	**///*/10 * * * * /usr/bin/php /var/www/html/vote2/vote/index.php r=Portal/Index/redis_db
	// 5 */10 * * * * /usr/bin/php /data/wwwroot/gonghui.jupiter.com/console/index.php r=auto_fetch/orders
	// 每小时05分运行 自动拉取订单
	//本机：~/Work/Baidu/Jupiter/Jupiter_Web/opentool.jupiter.com/console/index.php r=auto_fetch/orders 
	public function ordersAction(){
		list( $time_from, $time_to, $t, $h) = $this->parseFromTo();
		$time_from = '2017-11-14 08:35:05';
		$time_to = '2017-12-19 08:35:05';
		$iuser = _new("Service_IUser");
		$page = 1;
		$page_size = 50;

		$sql = "delete from  tb_order where payOrderTime > '$time_from' and payOrderTime <= '$time_to'";
		$data = Doris\DDB::execute($sql );
		$r = false;
		do{
			$r = $iuser->orderListGet($time_from, $time_to ,'321331',false,$page ,$page_size );
			//   [$recvedOK,$recvCode,$recvMsg,$recvData,$raw];
			//print_r($r);die;
			if($r[1] == 20000){//成功
				$unionid = Doris\DDB::fetchAll("select id,product_id,code from tb_unionlist");

				$fields = 'order_id, ktuid, channel, appid, payOrderTime, userip, amount, payState, extendbox, productID, serverID, union_id ';
				$values ='';
				$fields_arr = ['order_id','ktuid','channel','appid','payOrderTime','userip','amount','payState','extendbox','productID','serverID'];
				$datas = $r[3];

				foreach($datas  as $idx => &$data){
					if($data[$idx]['appid']==$unionid[$idx]['product_id'] && $data[$idx]['channel']==$unionid[$idx]['code']) {
						$values .= "(";
						array_walk($fields_arr, function ($v, $k) use (&$values, &$data) {
							if ($k > 0) $values .= ",";
							$values .= "'" . $data[trim($v)] . "'";
						});
						$values .= ",'".$unionid[$idx]['id']."'";
						$values .= "),";
					}
				}
				if(!empty($values)){
					$values = trim($values,',');
					$sql = "INSERT INTO tb_order ($fields ) values ".$values;
					//echo $sql;
					$result = Doris\DDB::execute($sql );
					// Doris\debugWeb( $sql );
					echo $page;
				}

			}else{
				//出错
			}
			sleep(1); // 休息一下，不要频繁拉大数据
			$page ++;
		}while( !empty($r[3]) && count($r[3]) ==  $page_size );
	}
	
	
	/**
	*	自动拉取用户
	*	
	**/
	// 10 */10 * * * * /usr/bin/php /data/wwwroot/gonghui.jupiter.com/console/index.php r=auto_fetch/users
	// 每小时10分运行 
	//本机：~/Work/Baidu/Jupiter/Jupiter_Web/opentool.jupiter.com/console/index.php r=auto_fetch/users 
	public function usersAction(){
		list( $time_from, $time_to, $t, $h) = $this->parseFromTo();

		$time_from = '2017-11-28 11:00:33';
		$time_to = '2017-12-19 08:35:05';
		$iuser = _new("Service_IUser");
		$page = 1;
		$page_size = 100;

		$sql = "delete from  tb_game_union_user_reg where reg_time > '$time_from' and reg_time <= '$time_to' ";
		$data = Doris\DDB::execute($sql );
		$r = false;
		do{
			$r = $iuser->unionListGet($time_from,  $time_to,false, $page ,$page_size ) ;
			if($r[1] == 20000){//成功

				$unionid = Doris\DDB::fetchAll("select id,product_id,code from tb_unionlist");
				$fields = 'id , game_id, ktuid, user_name, nick_name, channel, cps_channel, userphone, union_id,reg_time';
				$values ='';
				$fields_arr = ['id','appid','ktuid','username','nickname','channel','cps_channel','userphone','regtime'];
				$datas = $r[3];
				foreach($datas  as $idx => &$data){
					if($data[$idx]['appid']==$unionid[$idx]['product_id'] && $data[$idx]['channel']==$unionid[$idx]['code']){
						$values .= "(" ;
						array_walk($fields_arr ,function ($v,$k) use(&$values,&$data ) {
							//print_r($data[trim($v)]);
							if($k > 0)  $values .= "," ;
							$values .= "'".$data[trim($v)] ."'" ;
						});
						$values .= ",'".$unionid[$idx]['id']."'";
						$values .= ")," ;
						//echo $values;
					}


				}
				if(!empty($values)){
					$values = trim($values,',');
					echo $values;
					$sql = "INSERT INTO tb_game_union_user_reg ($fields ) values $values";
					//echo $sql;
					$result = Doris\DDB::execute($sql );
					// Doris\debugWeb( $sql );
					echo $page;
				}

			}else{
				//出错
			}
			sleep(1); // 休息一下，不要频繁拉大数据
			$page ++;
		}while( !empty($r[3]) && count($r[3]) ==  $page_size );
	}
	 
	//  0 */1 * * * /usr/bin/php /data/www/opentool.jupiter.com/console/index.php r=auto_fetch/test 
	//本机：~/Work/Baidu/Jupiter/Jupiter_Web/opentool.jupiter.com/console/index.php r=auto_fetch/test 
	public function testAction(){
		echo 123;
	}
	
	
	
	
 
}

