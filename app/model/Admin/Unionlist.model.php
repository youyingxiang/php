<?php 
class Admin_UnionlistModel{
    public function __construct(){
        
    }
    
  
    
    public static function readUnionInfoById($union_id){
        if(!$union_id){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare('select * from tb_unionlist where id = ?');
        $stmt->bindParam(1,$union_id);
        $stmt->execute();
        $union_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $union_info;
    }

    public static function updateById($updateArgs,$id){
        $tb_unionlist = Doris\DDB::db()->tb_unionlist[$id];
        foreach($updateArgs as $k=>$v){
            $tb_unionlist[$k] = $v;
        }
        return $tb_unionlist->update();

    }

    //获取渠道列表
    public static function readList($product_id,$state=""){
        if(!$product_id){
            return false;
        }
        $sql = 'select * from tb_unionlist where product_id = ?';
        if($state){$sql.=' and state=?';}
        $stmt = Doris\DDB::pdoSlave()->prepare($sql);
        $stmt->bindParam(1,$product_id);
        if($state){$stmt->bindParam(2,$state);}
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;

    }

    public static function readListInIds($ids){
        if(!$ids){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare("select * from tb_unionlist where id in ($ids)");
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }
    

}