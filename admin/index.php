<?php
date_default_timezone_set('Asia/Shanghai');
//浏览器类型
$regex_match="/(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^ucweb|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i";
/* 是否开启调试模式 */
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_PARSE);


//file_put_contents('test.txt',file_get_contents("php://input"));
//if (!empty($_SESSION['admin']['id'])) {
//	file_put_contents('session.txt',$_SESSION['admin']['id']);
//}


require '../doris/Startup.php';

// $app = "public";

// if(preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']))){
//     $app = Doris\DApp::getInstance("mobile.conf.php");
// }else{
//     $app = Doris\DApp::getInstance("admin.conf.php");
// }
$app = Doris\DApp::getInstance("mobile.conf.php");
Doris\DConfig::register("init_config.conf.php"	,"init_config");
Doris\DConfig::register("rediskeys.conf.php"	,"rediskeys");		
Doris\DConfig::register("rediskeys.conf.php","rediskeys");			
		
function _app(){global $app;return $app;}
function dd($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit;
}
function xmlToArray($xml){ 
 
 //禁止引用外部xml实体 
 
	libxml_disable_entity_loader(true); 
	 
	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
	 
	$val = json_decode(json_encode($xmlstring),true); 
	 
	return $val; 
 
} 


$app->run();

