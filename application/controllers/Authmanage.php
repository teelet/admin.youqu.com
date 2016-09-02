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
        $pageSize = 1;
        $currentPage = (int)Comm_Context::param('page', 1);
        //日志总条数
        $logCount = User_UserModel::getRootLogCount();
        //日志详细
        $logs = User_UserModel::getRootLog($currentPage, $pageSize);

        $this->tpl = 'authManage.phtml';
        $this->data['auth'] = Comm_Config::getPhpConf('auth.auth');
        $this->data['roots'] = User_UserModel::getAllRoot();
        $this->data['logs'] = $logs;
        $this->data['page'] = $currentPage;
        $this->data['pageSum'] = ceil($logCount / $pageSize);
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
        $this->data['res_msg'] = $res_msg['msg'];

        $this->indexAction();
    }


    public function updateRootAction(){
    	if(empty($_POST)){
    		echo "非法提交!";
    		die;
    	}

    	$user = trim(Comm_Context::form("username",""));
    	$auth_arr = Comm_Context::form("auth",array());
        if($user == 'root'){
            echo "非法提交!";
            die;
        }
    	$res_msg = User_UserModel::updateRoot($user,$auth_arr);
        $this->data['res_msg'] = $res_msg;

        $this->indexAction();
    }


}