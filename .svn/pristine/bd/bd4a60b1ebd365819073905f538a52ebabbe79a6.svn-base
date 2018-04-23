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

class cm_noticeController extends cps_commonController{



    public function indexAction(){
        if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
            $this->error('您没有权限进行此操作','index.php');
            exit;
        }
        //$this->assign("menu", "cps_manage/menu");
        $this->assign("js", "cps_manage/cm_notice_list.js");
        //$this->assign("js_para", json_encode(array("privilege_code"=>"n")));

        //$this->assign("js_privilege", json_encode(array("privilege_code"=> 5 )));

        $this->assign("title", _lan('BackgroundUserManagement','CPS公告管理'));
        $this->render(false,"common_list.tpl");
    }

    public function index_ajaxAction(){
        $db = Doris\DApp::loadDT();
        $data = Editor::inst( $db, 'tb_notice' ,"id" )
            ->fields(
                Field::inst( 'id' ),
                Field::inst( 'title' )
                    ->validator( 'Validate::notEmpty' ),
                Field::inst( 'content' ),
                Field::inst( 'keyword' ),
                Field::inst( 'adminid' )
                    ->options( 'tb_sys_user', 'id', 'user_name' )
                    ->validator( 'Validate::notEmpty' )

            )
            ->process( $_POST )
            ->data();
        echo json_encode($data);
    }



}