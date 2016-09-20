<?php
/**
 * ajax验证用户登录信息
 * User: shaohua5
 * Date: 16/8/30
 * Time: 下午2:15
 */

class Ajax_CheckloginController extends AbstractController{
    /**
     * 默认动作
     */
    public function indexAction() {
        $username = trim(Comm_Context::form('username', ''));
        $password = trim(Comm_Context::form('password', ''));
        if(empty($username) || empty($password)){
            $this->data = array(
                'status'   => 1,
                'errorMsg' => '用户名、密码 错误!'
            );
            return $this->end();
        }else{
            //验证用户名+密码
            $msg = User_UserModel::checkLoginInfo($username, $password);
            switch ($msg){
                case -1 :
                    $this->data = array(
                        'status'   => 1,
                        'type'     => 1,
                        'errorMsg' => '用户名不存在!'
                    );
                    break;
                case -2 :
                    $this->data = array(
                        'status'   => 1,
                        'type'     => 2,
                        'errorMsg' => '密码错误!'
                    );
                    break;
                case 0  :
                    $this->data = array(
                        'status'   => 0,
                        'errorMsg' => '成功!'
                    );
                    break;
            }
            //入session,cookie
            $expire = time() + 3600 * 12;
            setcookie('user', $username, $expire);
            setcookie('status', 'login', $expire);
        }

        $this->jsonResult();
        return $this->end();
    }
}