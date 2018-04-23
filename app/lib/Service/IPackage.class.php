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

class Service_IPackage extends Service_ICenterBase{
	
 	public function __construct( ){ 
        parent::__construct();
        $this->icenter_conf = DConfig::get("ipackage");
 	}


    // MARK: 渠道
    // 渠道——自动打包
    public function createPackage($game_id,$union_id,$child_union_id,$union_code,$child_union_code,$package_name,$game_version,$package_file,$keystore_file,$keystore_alias,$keystore_pwd,$notify_url,$package_file_id = 0){

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
        $sign_arr['child_union_code'] = $child_union_code;
        $sign_arr['child_union_id'] = $child_union_id;
        $sign_arr['game_id'] = $game_id;
        $sign_arr['game_version'] = $game_version;
        $sign_arr['keystore_alias'] = $keystore_alias;
        $sign_arr['keystore_password'] = $keystore_pwd;
        $sign_arr['notify_url'] = $notify_url;
        $sign_arr['package_file_id'] = $package_file_id;
        if($package_name){
            $sign_arr['package_name'] = $package_name;
        }
        $sign_arr['union_code'] = $union_code;
        $sign_arr['union_id'] = $union_id;

        $un_sign_arr = array();
        if($package_file){
            $un_sign_arr['package'] = "@{$package_file}";
        }
        if($keystore_file){
            $un_sign_arr['keystore'] = "@{$keystore_file}";
        }
        return $this->sendICenter("ipackage", "ipackage/package" , "POST"  ,$sign_arr ,$un_sign_arr);
    }

    public function uploadPackageFile($package_file){
        $un_sign_arr = array('package'=>"@{$package_file}");
        return $this->sendICenter("ipackage", "ipackage/uploadPackageFile" , "POST"  ,array() ,$un_sign_arr);
    }

    public function pushCDN($product_id,$union_id,$child_union_id,$game_version){
        $sign_arr['child_union_id'] = $child_union_id;
        $sign_arr['game_id'] = $product_id;
        $sign_arr['game_version'] = $game_version;
        $sign_arr['union_id'] = $union_id;
        return $this->sendICenter("ipackage", "ipackage/pushCDN" , "POST"  ,$sign_arr ,[]); 
    }

    public function refreshCDN($cdn_url){
        $sign_arr['cdn_url'] = $cdn_url;
        return $this->sendICenter("ipackage", "ipackage/refreshCDN" , "POST"  ,$sign_arr ,[]); 
    }

    public function warmCDN($cdn_url){
        $sign_arr['cdn_url'] = $cdn_url;
        return $this->sendICenter("ipackage", "ipackage/warmUpCDN" , "POST"  ,$sign_arr ,[]); 
    }
    
	

}