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
_load("Service_ICenterBase");

class Service_ICenter extends Service_ICenterBase{
	
// 	public function __construct( ){ 
//        	parent::__construct();
// 	}
    // MARK: 用户相关
    // 用户——获取列表
    public function unionUsersGet($since,  $time_to, $union_id = false, $page = 0 , $page_size = 100){
	 	 
	 	$sign_arr = array();
        if( !empty($union_id)){$sign_arr['union_id'] = $union_id;}
        $sign_arr['since'] = $since;
        $sign_arr['time_to'] = $time_to;
         
		return $this->sendICenter("iuserplat", "iuserplat/unionUsers" , "GET"  ,$sign_arr , [
				"page"=> $page ,
				"page_size"=> $page_size
			]); 
	}

	// MARK: 返利配置相关
	// 返利配置——增加或修改
	public function rebateAdd($game_id, $union_id,$ratio){
		
		$r = $this->sendICenter("iorder", "iorder/rebate" , "POST"  ,[
				'game_id' => $game_id,
				'ratio' => $ratio , 
				'union_id' => $union_id, 
			] ); 
		if( $r[1] == 0){
			 return $r;
		}
		$r = $this->sendICenter("iorder", "iorder/rebate" , "PUT"  ,[
					'game_id' => $game_id,
					'ratio' => $ratio , 
					'union_id' => $union_id, 
				] );
		return $r; 
	}
	// 返利配置——删除
	public function rebateDel($game_id, $union_id ){

		$r = $this->sendICenter("iorder", "iorder/rebate" , "DELETE"  ,[
				'game_id' => $game_id, 
				'union_id' => $union_id, 
				] );
		return $r; 
		
	}
	
	
	
	// MARK: 订单相关 
	// 渠道——获取列表
	public function orderGet($since, $time_to,$game_id = false,$union_id = false,$page = 0, $page_size = 100 ){
	  
	 	$sign_arr = array();
        if( !empty ($game_id) ){$sign_arr['game_id'] = $game_id;}
        $sign_arr['since'] = $since;
        $sign_arr['time_to'] = $time_to;
        if( !empty ($union_id) ){$sign_arr['union_id'] = $union_id;}

		
		return $this->sendICenter("iorder", "iorder" , "GET"  ,$sign_arr , [
				"page"=> $page ,
				"page_size"=> $page_size
			]); 
	}
	
	// MARK: 渠道相关 
	// 渠道——获取列表
	public function unionListGet($user_name, $password , $since_id ,$game_id = false ,$page = 0, $page_size = 100 ){
	 	
	 	$sign_arr = array();
        if( !empty ($game_id) ){$sign_arr['game_id'] = $game_id;}
        $sign_arr['password'] = $password;
        $sign_arr['since'] = $since_id;
        $sign_arr['user_name'] = $user_name;
        
		  
		return $this->sendICenter("iunion", "iunion" , "GET"  ,$sign_arr , [
				"page"=> $page ,
				"page_size"=> $page_size
			]); 
	}


    // MARK: 渠道
    // 渠道——自动打包
    public function createPackage($game_id,$union_id,$child_union_id,$package_name,$game_version,$package_file,$keystore_file,$keystore_alias,$keystore_pwd){

        $sign_arr = array();
        /*
         *      'child_union_id' =>'11',
                'game_id' =>520001,
                'game_version' =>'1.0.0',
                'keystore_alias' =>'520001',
                'keystore_password' =>'416542',
                'package_name' =>'package_name',
                'union_id' => '10086',
         */
        $sign_arr['child_union_id'] = $child_union_id;
        $sign_arr['game_id'] = $game_id;
        $sign_arr['game_version'] = $game_version;
        $sign_arr['keystore_alias'] = $keystore_alias;
        $sign_arr['keystore_password'] = $keystore_pwd;
        $sign_arr['package_name'] = $package_name;
        $sign_arr['union_id'] = $union_id;

        $un_sign_arr = array('package'=>"@{$package_file}");
        $un_sign_arr['keystore'] = $keystore_file?"@{$keystore_file}":'';
        return $this->sendICenter("ipackage", "ipackage" , "GET"  ,$sign_arr ,$un_sign_arr);
    }
	

}