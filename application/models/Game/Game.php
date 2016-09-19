<?php
/**
 * 操作游戏
 * User: shaohua5
 * Date: 16/9/18
 * Time: 上午10:38
 */

class Game_GameModel {

    const db = 'gameinfo';

    /*
     * 获取游戏列表
     */
    public static function getGameList(){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $gameList = $instance->select('game', array('gid', 'name'), array('status' => 0));
        return $gameList;
    }

    /*
     * 获取游戏角色
     * gid 游戏id
     */
    public static function getGameRoles($gid){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $sql = 'select a.gid, a.rid, b.name from game_roles a LEFT JOIN role b on a.rid = b.rid where a.gid = '.$gid;
        $roles = $instance->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    }
}
