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

class cm_levelController extends cps_commonController{



    public function indexAction(){
        if($this->is_cpsManager($_SESSION['admin']['id']) > 0){
            $this->error('您没有权限进行此操作','index.php');
            exit;
        }
        //$this->assign("menu", "cps_manage/menu");
        $this->assign("js", "cps_manage/cm_level_list.js");

        $this->assign("js_privilege", json_encode(array("privilege_code"=> 7 )));

        $this->assign("title", _lan('BackgroundUserManagement','CPS等级管理'));
        $this->render(false,"common_list.tpl");
    }

    public function index_ajaxAction(){
        $db = Doris\DApp::loadDT();
        $data = Editor::inst( $db, 'tb_user_level' ,"id" )
            ->fields(
                Field::inst( 'id' ),
                Field::inst( 'name' )
                    ->validator( 'Validate::notEmpty' ),
                Field::inst( 'user_rebate' )
                    ->validator( 'Validate::notEmpty' ),
                Field::inst( 'desc' )

            )
            ->process( $_POST )
            ->data();
        echo json_encode($data);
    }



}