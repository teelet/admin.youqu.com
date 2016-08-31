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


    public function updateRootAction(){
    	if(empty($_POST)){
    		echo "非法提交!";
    		die;
    	}
    	$this->tpl = 'authManage.phtml';

    	$user = Comm_Context::form("username","");
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