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
_load("Service_IUserBase");
#require
class Service_IUser extends Service_IUserBase{
	
// 	public function __construct( ){ 
//        	parent::__construct();
// 	}



	public function userinfo($sign_arr){
		$url = "http://mmhallapi.mmpkk.com:8889/query/getuserinfos";
		//echo $this->getcode();die;
		$res = $this->isend($url,$sign_arr,$this->getcode(),'POST');
		print_r($res);
	}

    // MARK: 用户相关
    // 用户——获取列表
    public function unionListGet($since,  $time_to, $union_id = false, $page =  0, $page_size = 50){
	 	 
	 	$sign_arr = array();
        $sign_arr['channel'] = $union_id;
        $sign_arr['start_time'] = $since;
        $sign_arr['end_time'] = $time_to;
        $sign_arr['page'] = $page;
        $sign_arr['page_size'] = $page_size;
         
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'getChannleUserList');

	}

	// 获取订单列表
	public function orderListGet($since, $time_to,$game_id = false,$union_id = false,$page = 0, $page_size = 100 ){

		$sign_arr = array();
		$sign_arr['start_time'] = $since;
		$sign_arr['end_time'] = $time_to;
		$sign_arr['game_id'] = $game_id	;
		$sign_arr['channel'] = $union_id;

		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Getchannellist');
	}

	// 获取渠道列表
	public function channelListGet($since, $union_id){

		$sign_arr = array();
		$sign_arr['channel'] = $union_id;
		$sign_arr['start_time'] = $since;
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Getchannellist');
	}

	// 获取渠道数据
	public function channelDataGet( $appid,$since,$time_to){

		$sign_arr = array();
		$sign_arr['appid'] = $appid;
		$sign_arr['start_time'] = $since;
		$sign_arr['end_time'] = $time_to;
		//$sign_arr['channel'] = $channel;
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Getchanneldata');
	}

	// 获取返利列表
	public function discountListGet( $channel_id,$plattype){

		$sign_arr = array();
		$sign_arr['channel_id'] = $channel_id;
		$sign_arr['plattype'] = $plattype;
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Getdiscountlist');
	}

	//添加返利配置
	public function addDiscount($act_auth,$url,$open_flag,$channel_id,$game_channel,$appid,$discount,$plattype){
		$sign_arr['channel_id'] = $channel_id;
		$sign_arr['game_channel'] = $game_channel;
		$sign_arr['appid'] = $appid;
		$sign_arr['gonghui_discount'] = $discount;
		$sign_arr['open_flag'] = $open_flag;
		$sign_arr['plattype'] = $plattype;
		$sign_arr['open_flag'] = $open_flag;

		//日志
		$sign_arr['act_auth'] = $act_auth;
		$sign_arr['url'] = $url;
		$sign_arr['projectname'] = 'guild';
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Adddiscount');
	}

	//修改、删除返利配置
	public function upDiscount($act_auth,$url,$id,$open_flag,$channel_id='',$game_channel='',$appid='',$discount=''){
		$sign_arr['id'] = $id;
		$sign_arr['open_flag'] = $open_flag;
		if($sign_arr['open_flag'] != 0){
			$sign_arr['channel_id'] = $channel_id;
			$sign_arr['game_channel'] = $game_channel;
			$sign_arr['appid'] = $appid;
			$sign_arr['gonghui_discount'] = $discount;
		}
		//日志
		$sign_arr['act_auth']=$act_auth;
		$sign_arr['url']=$url;
		$sign_arr['projectname']='guild';
		return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Updatediscount');
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
	public function unionListGet1($user_name, $password , $since_id ,$game_id = false ,$page = 0, $page_size = 100 ){
	 	
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

    //添加渠道
    /*
     * $channel_name 渠道名
     * $appid        游戏id
     * $channel_code 渠道标识
     * $plat_type    平台类型
     * $open_type    渠道状态
     * $pid          父渠道id
     * $auth_user    操作人
     *
     */
    public function unionAdd($channel_name,$appid,$channel_code,$plat_type,$open_flag,$pid,$auth_user){
        $sign_arr = array(
            'channel_name' => $channel_name ,
            'appid'=> $appid,
            'pid'=>$pid,
            'channel'=>$channel_code,
            'plattype'=>$plat_type,
            'open_flag'=>$open_flag,
            'channel_type'=>'gonghui',
            'act_auth'=>$auth_user,
            'url'=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']
        );
        return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'addgonghuichannel');
    }

    //渠道修改
    public function unionUpdate($channel_id,$channel_name,$plat_type,$open_flag,$auth_user){
        $sign_arr = array(
            'channel_id' => $channel_id,
            'channel_name'=>$channel_name,
            'plattype'=>$plat_type,
            'open_flag'=>$open_flag,
            'channel_type'=>'gonghui',
            'act_auth'=>$auth_user,
            'url'=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']
        );
        return $this->sendIUser("guild", "guild/channle"  ,$sign_arr,[],'Updategonghuichannel');
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