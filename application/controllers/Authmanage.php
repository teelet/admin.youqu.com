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

        $this->assign();
        return $this->end();
    }
}