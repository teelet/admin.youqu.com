<?php
/**
 * 添加别名
 * User: shaohua5
 * Date: 16/8/29
 * Time: 下午3:14
 */

class AddaliasController extends AbstractController {

    /**
     * 默认动作
     */

    public function indexAction() {
        $this->tpl = 'addAlias.phtml';

        $this->assign();
        return $this->end();
    }
}