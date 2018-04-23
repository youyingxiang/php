<?php
/**
 * Created by PhpStorm.
 * User: 7
 * Date: 2017/11/11
 * Time: 15:33
 */
require("./phprpc_client.php");
use app\source\phprpc\PHPRPC_Client;
class UserController{
    private $appkey = '6e96d9a7a1c7d2de873735bcf6f52d9a';

    /**
     * 获取渠道用户列表
     */
    public function actionTestuserlist(){
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client("http://test.userrpc.ktsdk.com/guild/channle");
        $data['channel'] = 'ktcs';
        $data['start_time'] = '2017-11-28 11:00:33';
        $data['end_time'] = '2017-12-15 08:35:05';
        $data['projectname'] = 'guild';
        $data['sign'] = $this->createSign($data,$this->appkey);
        $res = $client->getChannleUserList($data);
        $res = json_decode($res,true);
        #echo "<pre>";
        var_dump($res);
    }


    /**
     * 获取渠道 列表
     */
    public function actionTestorderlist(){
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client("http://test.userrpc.ktsdk.com/guild/channle");
        $data['channel'] = 'ktcs';
        $data['start_time'] = '2017-12-14 08:35:05';
        $data['end_time'] = '2017-12-19 08:35:05';
        $data['projectname'] = 'guild';
        $data['sign'] = $this->createSign($data,$this->appkey);
        $res = $client->Getchannellist($data);
        $res = json_decode($res,true);
        echo "<pre>";
        var_dump($res);
    }


    /**
     * 获取渠道 列表
     */
    public function actionTestchannellist(){
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client("http://test.userrpc.ktsdk.com/guild/channle");
        $data['channel'] = 'ktcs';
        $data['start_time'] = '2017-12-14 08:35:05';

        $data['projectname'] = 'guild';
        $data['sign'] = $this->createSign($data,$this->appkey);
        $res = $client->Getchannellist($data);
        $res = json_decode($res,true);
        echo "<pre>";
        var_dump($res);
    }

    /**
     * 获取渠道数据
     */
    public function actionTestchanneldata(){
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client("http://test.userrpc.ktsdk.com/guild/channle");
        $data['appid'] = '1011';
        $data['start_time'] = '2017-12-14 08:35:05';
        $data['end_time'] = '2017-12-16 18:35:05';
        $data['channel'] = 'ktcs';
        $data['projectname'] = 'guild';
        $data['sign'] = $this->createSign($data,$this->appkey);
        $res = $client->Getchanneldata($data);
        $res = json_decode($res,true);
        echo "<pre>";
        var_dump($res);
    }

    /**
     * 获取返利列表
     */
    public function actionTestdiscountlist(){
        $client = new PHPRPC_Client();
        $client->_PHPRPC_Client("http://test.userrpc.ktsdk.com/guild/channle");
        $data['channel_id'] = '100';
        $data['plattype'] = '1';
        $data['projectname'] = 'guild';
        $data['sign'] = $this->createSign($data,$this->appkey);
        $res = $client->Getdiscountlist($data);
        $res = json_decode($res,true);
        echo "<pre>";
        var_dump($res);
    }

    public function createSign($data,$appkey){
        ksort($data);
        $pair = array();
        foreach($data as $k => $v){
            if($v==''){
                continue;
            }
            $pair[] = $k.'='.$v;
        }
        $str = implode('#', $pair);
        $sign = md5($str.$appkey);
        return $sign;
    }
}

$a = new UserController();
$a->actionTestorderlist();