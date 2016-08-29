<?php
/**
 * 登录
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午2:42
 */

class LoginController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'login.phtml';

        $this->assign();
        return $this->end();
    }
}