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

class cm_applyController extends cps_commonController{



    public function indexAction(){
        if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
            $this->error('您没有权限进行此操作','index.php');
            exit;
        }
        //$this->assign("menu", "cps_manage/menu");
        $this->assign("js", "cps_manage/cm_apply_list.js");
        //$this->assign("js_para", json_encode(array("privilege_code"=>"n")));

        $this->assign("js_privilege", json_encode(array("privilege_code"=> 0 )));

        $this->assign("title", _lan('BackgroundUserManagement','CPS申请总代管理'));
        $this->render(false,"common_list.tpl");
    }

    public function index_ajaxAction(){
        $db = Doris\DApp::loadDT();
        $data = Editor::inst( $db, 'tb_apply' ,"id" )
            ->fields(
                Field::inst( 'id' ),
                Field::inst( 'name' ),
                Field::inst( 'amount' ),
                Field::inst( 'userid' ),
                Field::inst( 'apptime' )->getFormatter(function ($val, $data, $field) {
                    return date("Y-m-d H:i:s",$val);
                })
            )
            ->process( $_POST )
            ->data();
        echo json_encode($data);
    }



}