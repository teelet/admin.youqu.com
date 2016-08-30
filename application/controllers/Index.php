<?php
/**
 * @name IndexController
 * @desc 默认控制器
 */

class IndexController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        //判断用户是否登录
        $status = $_COOKIE['status'];
        if(empty($status) || $status == 'logout'){
            header('location: /login');
        }
        $userName = $_COOKIE['user'];
        $this->tpl = 'main.phtml'; //试图页面
        $this->data['userName'] = $userName;

        //所有权限
        $allAuth = Comm_Config::getPhpConf('auth.auth');
        //权限所属类目
        $allClass = Comm_Config::getPhpConf('auth.class');
        //获取管理员的权限
        $userAuth = User_UserModel::getUserAuth($userName);
        if($userAuth == '*'){
            $userAuth = array_keys($allAuth);
        }else{
            $userAuth = explode(',', $userAuth);
        }
        //过滤用户权限
        $this->data['auth'] = array();
        foreach ($userAuth as $auth){
            $item = $allAuth[$auth];
            $this->data['auth'][$item['classId']][] = $item;
        }
        ksort($this->data['auth']);
        $this->data['class'] = $allClass;
        //渲染
        $this->assign();
        return $this->end();
    }
}