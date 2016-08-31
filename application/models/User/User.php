<?php
/**
 * User 类
 * User: shaohua5
 * Date: 16/8/30
 * Time: 上午10:57
 */

class User_UserModel {

    const db = 'gameinfo';

    public static function getUserAuth($userName){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $auth = $instance->select('root', array('auth'), array('username' => $userName))[0];
        return $auth['auth'];
    }

    public static function checkLoginInfo($userName, $password){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        //验证用户名是否存在
        $info = $instance->select('root', array('username'), array('username' => $userName))[0];
        if(empty($info)){ //用户名不存在
            return -1;
        }
        $salt = Comm_Config::getPhpConf('auth.salt'); //盐值
        $password = sha1($password.$salt);
        $info = $instance->select('root', array('username'), array('and' => array('username' => $userName, 'password' => $password)))[0];
        if(empty($info)){ //密码错误
            return -2;
        }
        return 0;
    }
}