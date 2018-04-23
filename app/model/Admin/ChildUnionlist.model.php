<?php 
class Admin_ChildUnionlistModel{
    public function __construct(){
        
    }
    
  
    
    public static function readUnionInfoById($child_union_id){
        if(!$child_union_id){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare('select * from tb_childunionlist where id = ?');
        $stmt->bindParam(1,$child_union_id);
        $stmt->execute();
        $union_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $union_info;
    }

    public static function updateById($updateArgs,$id){
        $tb_childunionlist = Doris\DDB::db()->tb_childunionlist[$id];
        foreach($updateArgs as $k=>$v){
            $tb_childunionlist[$k] = $v;
        }
        return $tb_childunionlist->update();

    }

    //获取子渠道列表
    public static function readList($parent_id,$state=""){
        if(!$parent_id){
            return false;
        }
        $sql = 'select * from tb_childunionlist where parent_id = ?';
        if($state){$sql.=' and state=?';}
        $stmt = Doris\DDB::pdoSlave()->prepare($sql);
        $stmt->bindParam(1,$parent_id);
        if($state){$stmt->bindParam(2,$state);}
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;

    }

    public static function readListInIds($ids){
        if(!$ids){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare("select * from tb_childunionlist where id in ($ids)");
        #$stmt->bindParam(1,$ids);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    

}