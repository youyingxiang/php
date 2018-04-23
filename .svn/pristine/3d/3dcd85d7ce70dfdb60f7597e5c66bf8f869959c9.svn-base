<?php 
/**
 * 访问ICenter接口 
 * @author qiaochenglei
 * 2017-04-29
 * 
 *
 */ 
 
use Doris\DApp,
 Doris\DCache,
 Doris\DLog,
 Doris\DConfig; 
_load("Service_IGameBase");
#require
class Service_IGame extends Service_IGameBase{


	//获取游戏区/服列表
	public function gameList($type,$appid,$pid=0){

		$sign_arr = array();
		$sign_arr['type'] = $type;
		$sign_arr['appid'] = $appid;
		$sign_arr['pid'] = $pid;

		return $this->sendIGame("guild_webpay", "payrpc/payrpc"  ,$sign_arr,[],'getArea');
	}

	//获取游戏商品列表
	public function shopList($type,$appid){

		$sign_arr['type'] = $type;
		$sign_arr['appid'] = $appid;

		return $this->sendIGame("guild_webpay", "payrpc/payrpc"  ,$sign_arr,[],'getProduct');
	}

	//获取用户角色列表
	public function userRole($type,$appid,$role_id,$server_id,$server_name){

		$sign_arr['type'] = $type;
		$sign_arr['appid'] = $appid;
		$sign_arr['role_id'] = $role_id;
		$sign_arr['server_id'] = $server_id;
		$sign_arr['server_name'] = $server_name;

		return $this->sendIGame("guild_webpay", "payrpc/payrpc"  ,$sign_arr,[],'checkUserByRoleid');
	}

}