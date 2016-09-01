<?php
/**
 * 权限管理
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:15
 */

class AuthmanageController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'authManage.phtml';
        $this->data['auth'] = Comm_Config::getPhpConf('auth.auth');
        $this->data['roots'] = User_UserModel::getAllRoot();
        $this->assign();
        return $this->end();
    }

    public function updatePasswdAction(){
        if(empty($_POST)){
            echo "非法提交!";
            die;
        }
        $user = trim(Comm_Context::form("username",""));
        $loginUser = $_COOKIE['user'];
        $password = trim(Comm_Context::form("password",''));
        if($user == 'root'){
            if($loginUser != $user){
                echo "非法提交!";
                die;
            }
        }
        $res_msg = User_UserModel::updatePassword($user, $password);
        if($res_msg['status'] == 0 && $user == $loginUser){ //重新登录
            echo '<script>alert("修改成功,请重新登录");window.parent.location.href = "/login";</script>';
        }

        $this->tpl = 'authManage.phtml';
        $this->data['auth'] = Comm_Config::getPhpConf('auth.auth');
        $this->data['roots'] = User_UserModel::getAllRoot();
        $this->data['res_msg'] = $res_msg['msg'];
        $this->assign();
        return $this->end();
    }


    public function updateRootAction(){
    	if(empty($_POST)){
    		echo "非法提交!";
    		die;
    	}
    	$this->tpl = 'authManage.phtml';

    	$user = trim(Comm_Context::form("username",""));
    	$auth_arr = Comm_Context::form("auth",array());
        if($user == 'root'){
            echo "非法提交!";
            die;
        }
    	$res_msg = User_UserModel::updateRoot($user,$auth_arr);

        $this->data['auth'] = Comm_Config::getPhpConf('auth.auth');
        $this->data['roots'] = User_UserModel::getAllRoot();
        $this->data['res_msg'] = $res_msg;
        $this->assign();
        return $this->end();
    }


}