<?php
/**
 * User 类
 * User: shaohua5
 * Date: 16/8/30
 * Time: 上午10:57
 */

class User_UserModel {

    const db = 'gameinfo';

    /**
     *  获取用户权限
     */
    public static function getUserAuth($userName){
        //获取数据库配置文件
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $auth = $instance->select('root', array('auth'), array('username' => $userName))[0];
        return $auth['auth'];
    }

    /**
     *  认证登录信息
     */

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

    /**
     *  获取管理员操作日志
     */

    public static function getRootLog($page = 1, $pageSize = 10){
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $start = ($page - 1) * $pageSize;
        $log = $instance->select('root_log', '*', array('ORDER' => array('atime' => 'DESC'),'LIMIT' => array($start, $pageSize)));
        return $log;
    }

    /**
     *  获取管理员日志总条数
     */

    public static function getRootLogCount(){
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $count = $instance->count('root_log');
        return $count;
    }

    /**
     *  得到所有管理员
    **/
    public static function getAllRoot(){
        // 连接数据库
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.read');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $users = $instance->select('root',array("username","auth","atime","excutor"),array());
        // 得到所有的auth
        $auth = Comm_Config::getPhpConf('auth.auth');
        for ($i=0; $i < count($users); $i++) { 
            $auth_tmp = explode(',', $users[$i]['auth']);
            if($auth_tmp[0] == '*'){
                $users[$i]['auth'] = "*";
            }else{
                $auth_tmp_arr = array();
                foreach ($auth_tmp as $v) {
                    $auth_tmp_arr[] = $auth[$v]["authName"];
                }
                $users[$i]['auth'] = implode(',', $auth_tmp_arr);
            }
        }
        return $users;
    }

    /**
     * 更新管理员密码
     */
    public static function updatePassword($userName, $password){
        if(empty($userName) || empty($password)){
            return false;
        }
        $salt = Comm_Config::getPhpConf('auth.salt'); //盐值
        $password = sha1($password.$salt);
        // 连接数据库
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.write');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        $res = $instance->update('root', array('password' => $password), array('username' => $userName));
        if($res){
            return array(
                'status' => 0,
                'msg'    => '更新管理员密码成功！'
            );
        }else{
            return array(
                'status' => 1,
                'msg'    => '更新管理员密码失败！'
            );
        }
    }


    /**
     *  更新用户的权限或者删除用户
    **/
    public static function updateRoot($userName, $auth_arr){
        // 连接数据库
        $config = Comm_Config::getPhpConf('db/db.'.self::db.'.write');
        $instance = Comm_Db_Handler::getInstance(self::db, $config);
        // 如果auth_arr为空，则删除用户,但是用户不一定存在; 否则，如果用户存在，更新权限 不存在则新建用户
        if(count($auth_arr) == 0){
            $ret = $instance->delete('root',array('username'=>$userName));
            if($ret){
                return "删除成功！";
            }else{
                return "删除用户不存在，无需删除！";
            }
        }else{
            // 先获取权限数量，如果auth_arr的大小等于所有权限的数量，则将数据库中的auth置为*
            $auth_count = count(Comm_Config::getPhpConf('auth.auth'));
            $auth = ($auth_count == count($auth_arr)) ? '*' : implode(',', $auth_arr);
            $ret = $instance->select('root',array('id'),array('username'=>$userName))[0];
            // 存在，则更新权限
            if($ret){
                $ret2 = $instance->update('root',array("auth"=>$auth),array('username'=>$userName));
                if($ret2){
                    return "更新用户“".$userName."”权限成功！";
                }else{
                    return "更新用户“".$userName."”权限失败！";
                }
            }else{  // 不存在，则创建用户，默认密码是123qwe，同时设置权限
                // 初始密码
                $salt = Comm_Config::getPhpConf('auth.salt'); //盐值
                $password = Comm_Config::getPhpConf('auth.init_password'); //初始密码
                $password = sha1(sha1($password).$salt);
                $ret3 = $instance->insert('root',array('username'=>$userName,'password'=>$password,'auth'=>$auth,'excutor'=>$_COOKIE['user']));
                if($ret3){
                    return "添加管理员成功！";
                }else{
                    return "添加管理员失败！";
                }
            }
        }
    }
}