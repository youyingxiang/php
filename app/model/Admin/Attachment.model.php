<?php 
class Admin_AttachmentModel{
    public function __construct(){
        
    }
    
  
    
    public static function readAttachmentById($id){
        if(!$id){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare('select * from tb_attachment where id = ?');
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $attachment_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $attachment_info;
    }

    public static function delAttachmentById($id){
        $id = $id+0;
        if(!$id){
            return false;
        }
        return Doris\DDB::pdo()->exec("delete from tb_attachment where id =  {$id} ");
    }

    //获取附件列表，根据游戏id,类型,版本
    public static function readAttachmentList($game_id,$type="",$version=""){
        $sql = "select * from tb_attachment where game_id = ?";
        if($type){ $sql.=" and type='{$type}'"; }
        if($version){ $sql.=" and version='{$version}'"; }
        $sql.=" order by create_time desc";
        $stmt = Doris\DDB::pdoSlave()->prepare($sql);
        $stmt->bindParam(1,$game_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateAttachmentById($updateArgs,$id){
        $tb_attachment = Doris\DDB::db()->tb_attachment[$id];
        foreach($updateArgs as $k=>$v){
            $tb_attachment[$k] = $v;
        }
        return $tb_attachment->update();

    }
    

}