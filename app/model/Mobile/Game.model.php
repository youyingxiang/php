<?php 
class Admin_GameModel{
    public function __construct(){
        
    }
    
  
    
    public static function readGameById($game_id){
        if(!$game_id){
            return false;
        }
        $stmt = Doris\DDB::pdoSlave()->prepare('select * from tb_games where game_id = ?');
        $stmt->bindParam(1,$game_id);
        $stmt->execute();
        $game_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $game_info;
    }
    

}